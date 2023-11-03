<?php

namespace App\Controller;

use App\Entity\Guitar;
use App\Entity\GuitarType;
use App\Entity\User;
use App\Entity\Image;
use App\Entity\ImageGuitar;
use App\Entity\Order;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Service\UserService;
use App\Service\GuitarService;
use App\Service\GuitarTypeService;
use App\Service\ImageGuitarService;
use App\Service\ImageService;
use App\Service\OrderService;
use DateTimeImmutable;
use Symfony\Component\Validator\Constraints\Date;

class IndexController extends AbstractController
{


    #[Route(path: '/', name: 'test')]
    public function test(
        Request $request,
        EntityManagerInterface $entityManager
    ): Response
    {

        // USER ANLAGE
        // $newUser = new User();

        // $email = "admin@email.de";
        // $Roles = ["User_Admin"];
        // $password = "adminadmin";
        // $street = "Teststraße";
        // $housenumber = 11;
        // $zipcode = 52432;
        // $city = "Berlin";
        // $firstname = "Flynn";
        // $lastname = "Tester";
        // $deleted = 0;

        // $newUser
        //     ->setEmail($email)
        //     ->setRoles($Roles)
        //     ->setPassword($password)
        //     ->setStreet($street)
        //     ->setHouseNumber($housenumber)
        //     ->setZipcode($zipcode)
        //     ->setCity($city)
        //     ->setFirstname($firstname)
        //     ->setLastname($lastname)
        //     ->setDeleted($deleted)
        //     ;


        // $entityManager->persist($newUser);
        // $entityManager->flush();

        return new Response("hey hey hey");

    }

    #[Route(path: '/bla', name: 'bla')]
    public function bla(
        Request $request,
        UserService $userService,
        GuitarService $guitarService,
        GuitarTypeService $guitarTypeService,
        ImageGuitarService $imageGuitarService,
        ImageService $imageService,
        OrderService $orderService,
    ): Response
    {

        // ----------------- TEST READ --------------------------
        // $guitar = $guitarService->get(1);
        // var_dump($guitar->getModel());
        // echo "<br><br>";

        // $user = $userService->get(1);
        // var_dump($user->getFirstname());
        // echo "<br><br>";

        // $guitarTypeService = $guitarTypeService->get(1);
        // var_dump($guitarTypeService->getType());
        // echo "<br><br>";

        // $imageService = $imageService->get(1);
        // var_dump($imageService->getName());
        // echo "<br><br>";

        // $orderService = $orderService->get(1);
        // var_dump($orderService->getDate());
        // echo "<br><br>";


        // $imageGuitarService = $imageGuitarService->get(5);
        // var_dump($imageGuitarService->getGuitar()->getModel());
        // echo "<br><br>";

        // ----------------- TEST UPDATE --------------------------

        // $guitar = $guitarService->get(1);
        // $guitar->setModel("test-modell");
        // $guitarService->store($guitar);

        // $user = $userService->get(1);
        // $user->setFirstname("test-Flynn");
        // $userService->store($user);

        // $guitarType = $guitarTypeService->get(1);
        // $guitarType->setType("test-type");
        // $guitarService->store($guitarType);

        // $image = $imageService->get(1);
        // $image->setName("test-name");
        // $imageService->store($image);

        // $order = $orderService->get(1);
        // $newDate = new \DateTimeImmutable();
        // $order->setDate($newDate);
        // $orderService->store($order);

        // ----------------- TEST CREATE --------------------------

        // $guitar = new Guitar();
        // $firstGuitarType = $guitarTypeService->get(1);
        // $firstOrder = $orderService->get(1);
        // $guitar
        //     ->setGuitarType($firstGuitarType)
        //     ->setModel("createTestModel")
        //     ->setDeleted(false)
        //     ->setColor("createText-color")
        //     ->setPrice("5666,00")
        //     ->setUsed(0)
        //     ->setGuitarOrder($firstOrder)
        //     ;
        // $guitarService->store($guitar);


        // $guitarType = new GuitarType();
        // $guitarType
        //     ->setVersion("test-create-version")
        //     ->setBrand("test-create-brand")
        //     ->setBody("test-create-body")
        //     ->setPickup("test-create-pickup")
        //     ->setType("rest-create-type")
        //     ->setSaddlewidth(999)
        //     ->setDeleted(false)
        //     ->setNeck("test-create-neck")
        //     ->setSize("test-create-size")
        //     ->setFretboard('test-create-Fretboard')
        //     ->setScale(888)
        //     ;
        // $guitarTypeService->store($guitarType);

        // $image = new Image();
        // $image 
        //     ->setName("test-create-name");
        // $imageService->store($image);

        // $imageGuitar = new ImageGuitar();
        // $firstImage = $imageService->get(1);
        // $firstGuitar = $guitarService->get(1);
        // $imageGuitar
        //     ->setImage($firstImage)
        //     ->setGuitar($firstGuitar)
        //     ;
        // $imageGuitarService->store($imageGuitar);
        
        // $order = new Order();
        // $dateOne = new \DateTimeImmutable();
        // $dateTwo = new \DateTimeImmutable();
        // $user = $userService->get(1);
        // $order
        //     ->setDate($dateOne)
        //     ->setPayDate($dateTwo)
        //     ->setUser($user)
        //     ;
        // $orderService->store($order);

        // $newUser = new User();
        // $email = "test@email.de";
        // $Roles = ["Role_User"];
        // $password = "useruser";
        // $street = "TestCreatestraße";
        // $housenumber = 999;
        // $zipcode = 888;
        // $city = "test-city";
        // $firstname = "test-create";
        // $lastname = "test-create-nachname";
        // $deleted = 0;
        // $newUser
        //     ->setEmail($email)
        //     ->setRoles($Roles)
        //     ->setPassword($password)
        //     ->setStreet($street)
        //     ->setHouseNumber($housenumber)
        //     ->setZipcode($zipcode)
        //     ->setCity($city)
        //     ->setFirstname($firstname)
        //     ->setLastname($lastname)
        //     ->setDeleted($deleted)
        //     ;
        // $userService->store($newUser);

        // ----------------- TEST DELETE --------------------------
        // $guitar = $guitarService->get(17);
        // $guitarService->remove($guitar);

        // $image = $imageService->get(8);
        // $imageService->remove($image);



        
        return $this->render("test.html.twig", [
            'item' => $item ??  "no item"
        ]);
    }


}


        // SO GEHTS
        // $item = $userService->get(1);
        // $item = $item->getOrders()->toArray();

        // $item = $guitarService->get(1);
        // $itemCollection = $item->getImageGuitar()->toArray();