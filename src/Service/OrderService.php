<?php

namespace App\Service;

use App\Entity\Order;
use Doctrine\ORM\EntityManagerInterface;
use App\Service\UserService;
use App\Service\GuitarService;
use App\Service\HelperService;
use App\Constants\ConfigurationVariables;

class OrderService extends AbstractEntityService
{

    private UserService $userService;
    private GuitarService $guitarService;
    private HelperService $helperService;

    public function __construct(
        EntityManagerInterface $entityManager,
        UserService $userService,
        GuitarService $guitarService,
        HelperService $helperService
        )
    {
        parent::__construct($entityManager);
        $this->userService = $userService;
        $this->guitarService = $guitarService;
        $this->helperService = $helperService;
        
    }

    public static $entityFqn = Order::class;


    /*
    * manages incoming Order
    */
    public function createOrder(Array $orderInfos) {
        $date = new \DateTime();     

        // payDate is 2 weeks later
        $payDate = new \DateTime();     
        $payDate->add(new \DateInterval('P2W'));

        $userId = $this->userService->createNewUserForOrder($orderInfos);
        if($userId){
            $user = $this->userService->get($userId);
            $guitarIds = $this->helperService->stringToArray($orderInfos['ids']);
            $order = new Order();
            $order
                ->setDate($date)
                ->setUser($user)
                ->setPayDate($payDate)
                ;

            if($this->store($order)){
                foreach ($guitarIds as $guitarId) {
                    $guitar = $this->guitarService->get($guitarId);
                    $order->setGuitar($guitar);
                    $this->store($order);
                }
            }
            return $order->getId() ?? false;
        }
        return false;
    }

    /*
    * switches paid state
    */
    public function switchPaid(int $orderId, bool $paid) : bool {
        $order = $this->get($orderId);
        $state = null;
        if ($paid) {
            $state = new \DateTime();
        }
        $order->setPaid($state);
        return $this->store($order) ? true : false;
    }


    /*
    * switches canceled state
    */
    public function switchCanceled(int $orderId, bool $canceled) : bool {
        $order = $this->get($orderId);
        $state = null;
        if ($canceled) {
            $state = new \DateTime();
        }
        $order->setCanceled($state);

        $returnValue = true;

        // remove order from ordered guitars
        if ($this->store($order)) {
            $returnValue = true;
            $guitars = $this->guitarService->getAllByOrderId($order->getId());
        
            forEach($guitars as $guitar) {
                $guitar->setGuitarOrder(null);
                // $this->guitarService->store($guitar);
                if (!$this->guitarService->store($guitar)) {
                    $returnValue = false;
                }
            }   
        } else {
            $returnValue = false;
        }
        return $returnValue;
    }


    public function getAllSortByDate(bool $isAsc)
    {
        $direction = $isAsc ? 'ASC' : 'DESC';

        return $this
            ->entityManager
            ->getRepository(static::$entityFqn)
            ->findBy([], ['date' => $direction])
            ;
    }

    public function provideInvoice(int $id)
    {
        $order = $this->get($id);
        $invoiceFileName = 'invoice_' . $id .'.txt';
        
        $invoiceFile = fopen("invoices/" . $invoiceFileName, "w") or die("Unable to open file!");
        $this->writeInvoiceToFile($invoiceFile, $order);
        fclose($invoiceFile);


        $file_url = ConfigurationVariables::LOCAL_PATH . '/invoices/' . $invoiceFileName;
        header('Content-Type: application/octet-stream');
        header("Content-Transfer-Encoding: Binary"); 
        header("Content-disposition: attachment; filename=\"" . basename($file_url) . "\""); 
        readfile($file_url);
        exit();
    }

    public function createInvoiceItemText($guitar){
        return "        |   ID: " . $guitar->getId() ."   | " . $guitar->getGuitarType()->getBrand() . " " . $guitar->getModel() . " - " . $guitar->getPrice() .",00 €";
    }

    public function computeTotalPrice($order){
        $guitars = $this->guitarService->getAllByOrderId($order->getId());
        $totalPrice = 0;
        foreach ($guitars as $guitar){
            $totalPrice = $totalPrice + $guitar->getPrice();
        }
        return $totalPrice;
    }

    public function coumputeSaleTax($price) {
        return ($price / 100) * 19; 
    }



    public function writeInvoiceToFile($file, $order) {
        $guitars = $this->guitarService->getAllByOrderId($order->getId());
        $guitarItemsText = "";
        foreach ($guitars as $guitar){
            $guitarItemsText = $guitarItemsText . "\n" . $this->createInvoiceItemText($guitar);
        }

        $totalPrice = $this->computeTotalPrice($order);
        $totalSalesTax = $this->coumputeSaleTax($totalPrice);

        $user = $order->getUser();

        $txt =         
        "
        Guitar World
        Berliner Straße 63
        55131 Musterstadt

        " . $user->getFirstname() . " " . $user->getLastname() . "
        " . $user->getStreet() . " " . $user->getHousenumber() . "
        " . $user->getZipcode() . " " . $user->getCity() . "

        Rechnung Nr.: " . $order->getId() . " 
        Rechnungsdatum: " . $order->getDate()->format('d.m.Y') . "


        Positionen:
        " . $guitarItemsText ."

        Enthaltene Umsatzsteuer (19%): " . $totalSalesTax  . " €

        Gesamtsumme: " . $totalPrice . ",00 €

        Zahlungsbedingungen: Zahlbar innerhalb von 14 Tagen nach Rechnungsdatum ohne Abzug.

        Bankverbindung:
        Flynn Tester
        Musterbank AG
        IBAN: DE12345678901234567890
        BIC: MUSTERBICXXX

        Vielen Dank für Ihren Einkauf!
        ";
        fwrite($file, $txt);
        return $file;
    }



    /*
    * Searches order by phrase (firstname, lastname, orderId, email)
    */
    public function getAllByPhrase(string $phrase) : array 
    {
        $queryBuilder = $this->createQueryBuilder();
        $queryBuilder
            ->innerJoin('r.user', 'u')
            ->where('
            r.id LIKE :phrase OR
            u.email LIKE :phrase OR
            u.firstname LIKE :phrase OR 
            u.lastname LIKE :phrase
            ')
            ->setParameter('phrase', '%' . $phrase . '%')
            ;

        return $queryBuilder->getQuery()->execute();
    }

}