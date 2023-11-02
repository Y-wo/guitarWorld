<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

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


}