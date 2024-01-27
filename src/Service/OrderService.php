<?php

namespace App\Service;

use App\Entity\Order;
use Doctrine\ORM\EntityManagerInterface;
use App\Service\UserService;
use App\Service\GuitarService;
use App\Service\HelperService;

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




    // TODO: Überarbeiten - schöner machen

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
}