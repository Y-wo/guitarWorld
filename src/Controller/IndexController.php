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


    #[Route(path: '/', name: 'home')]
    public function home(
    ): Response
    {        
        return $this->render("base.html.twig", [
            'item' => $item ??  "no item body blabla"
        ]);
    }

    #[Route(path: '/login', name: 'login')]
    public function login(
        Request $request,
        EntityManagerInterface $entityManager
    ): Response
    {

        return new Response("login");
        //check if userData are correct
        // $isAuthorized = $loginService->authenticate($request);

        // if(!$isAuthorized){
        //     $message = "Login nicht möglich.";
        //     return $this->redirectToRoute('login', [
        //         'message' => $message,
        //     ]);
        // }else{
        //     $message = "Herzlich Willkommen";
        //     return $this->redirectToRoute('index', [
        //         'message' => $message,
        //     ]);
        // }
    }

    #[Route(path: '/create-user', name: 'create_user')]
    public function createUser(
        Request $request,
        UserService $userService
    ): Response
    {        
        return $this->render("create_user.html.twig");
    }

    #[Route(path: '/save-user', name: 'save_user')]
    public function saveUser(
        Request $request,
        UserService $userService
    ): Response
    {        
        $userInfos = $userService->createRequestUserAssociativeArray($request);

        if(!$userService->emailExists($userInfos['email'])){

            // validate:
            // - CHECK email not existing
            // - email and email_confirmation is equal
            // - password and password_confirmation ist equal


            // hash password

            $emailExists = $userService->emailExists('admin@email.de');

            $user = new User();

            $user
                ->setFirstname($userInfos['firstname'])
                ->setLastname($userInfos['lastname'])
                ->setEmail($userInfos['email'])
                ->setStreet($userInfos['street'])
                ->setHouseNumber($userInfos['housenumber'])
                ->setPhone($userInfos['phone'])
                ->setBirthday($userInfos['birthday'])
                ->setCity($userInfos['city'])
                ->setBegin(new \DateTimeImmutable())
                ->setDeleted(0)
                ->setPassword($userInfos['password'])
                ->setZipcode($userInfos['zipcode'])
                ->setRoles(['ROLE_USER'])
            ;

            // $userService->store($user);
        }

        

        return $this->render("save_user.html.twig", 
            [
                'userInfos' => $userInfos ??  "no userInfos ",
                'allUsers' => $allUsers ?? "no all Users ",
                'emailExists' => $emailExists ?? "nassing hir"
            ]
        );
    }




}
