<?php

use App\Kernel;
use App\Entity\User;
// use Doctrine\ORM\EntityManagerInterface;
// use Symfony\Runtime\Doctrine\ORM\EntityManagerInterfaceRuntime;

require_once dirname(__DIR__).'/vendor/autoload_runtime.php';

return function (
    array $context,
    // EntityManagerInterface $entityManager
    // EntityManagerInterfaceRuntime $entityManager
    ) {

        // echo "hallo";

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
        
        // var_dump($newUser);


        // $entityManager->persist($newUser);
        // $entityManager->flush();
    
        return new Kernel($context['APP_ENV'], (bool) $context['APP_DEBUG']);
};
