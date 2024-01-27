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
        $userId = $this->userService->createNewUserForOrder($orderInfos);

        if($userId){
            $user = $this->userService->get($userId);
            $guitarIds = $this->helperService->stringToArray($orderInfos['ids']);

            $order = new Order();

            $order
                ->setDate($date)
                ->setUser($user)
                ;

            if($this->store($order)){
                foreach ($guitarIds as $guitarId) {
                    $guitar = $this->guitarService->get($guitarId);
                    $order->setGuitar($guitar);
                    $this->store($order);
                }
            }
            
            // return $this->store($storedOrder) ?  $order->getId() : false;
            return $order->getId() ?? false;
        }
        return false;
    }

}