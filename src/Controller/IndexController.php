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
          
        $message = $request->request->get('message') ?? null;
        return $this->render("create_user.html.twig", [
            'message' => $message,
            'request' => $request
        ]);
    }


    #[Route(path: '/save-user', name: 'save_user')]
    public function saveUser(
        Request $request,
        UserService $userService
    ): Response
    {        
        $userInfos = $userService->createRequestUserAssociativeArray($request);
        $userManipulationProcess = $userService->getUserManipulationProcess($request);

        // return create-user-template if user already exists
        if($userService->emailExists($userInfos['email'], true)){
            if($userManipulationProcess == 'create_new_user'){
                $message = 'Die E-Mail "'. $userInfos['email'] . '" existiert bereits';
                return $this->render('create_user.html.twig', [
                    'message' => $message,
                    'userInfos' => $userInfos,
                    'return' => true,
                    'request' => $request
                ]);
            }else{
                return $this->redirectToRoute('home');
            }
        }

        if($userInfos['email'] !== $userInfos['email_confirmation']){
            return new Response("Email stimmt nicht überein");
        }

        if($userInfos['password'] !== $userInfos['password_confirmation']){
            return new Response("Passwort stimmt nicht überein");
        }
        
        $hashedPassword = hash('md5', $userInfos['password']);
        
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
            ->setPassword($hashedPassword)
            ->setZipcode($userInfos['zipcode'])
            ->setRoles(['ROLE_USER'])
        ;
        
        $userService->store($user);

        return $this->render("save_user.html.twig", 
            [
                'userInfos' => $userInfos ??  "no userInfos ",
                'allUsers' => $allUsers ?? "no all Users ",
                'emailExists' => $userService->emailExists($userInfos['email'], true) ?? "nassing hir",
                'user_manipulation_process' => $userManipulationProcess,
                'request' => $request
            ]
        );
    }




}
