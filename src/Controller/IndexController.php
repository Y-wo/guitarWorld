<?php

namespace App\Controller;

use App\Entity\Guitar;
use App\Constants\SystemWording;
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
           'headline' => SystemWording::HELLO
        ]);
    }

    #[Route(path: '/login', name: 'login')]
    public function login(
        Request $request,
        EntityManagerInterface $entityManager
    ): Response
    {


        //check if userData are correct
        $isAuthorized = $loginService->authenticate($request);
        return new Response("login");


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
        $userManipulationProcess = $userService->getUserManipulationProcess($request);

        // process, if form ist submitted
        if ($userManipulationProcess == 'create_new_user') {
            $userInfos = $userService->createRequestUserAssociativeArray($request);
            if ($userService->emailExists($userInfos['email'], true)) {   
                return $this->render('create_user.html.twig', [
                    'message' => SystemWording::USER_ALREADY_EXISTS,
                    'userInfos' => $userInfos,
                    'return' => true,
                ]);
            }
            if ($userInfos['email'] !== $userInfos['email_confirmation'] || $userInfos['password'] !== $userInfos['password_confirmation']) {
                return $this->render('create_user.html.twig', [
                    'message' => SystemWording::ERROR_REGISTRATION,
                    'userInfos' => $userInfos,
                    'return' => true,
                ]);
            }

            if ($userService->createNewUser($userInfos)) {
                return $this->redirectToRoute('user_success', [
                    'success' => true,
                ]);
            } 
            else {
                return $this->render('create_user.html.twig', [
                    'message' => SystemWording::ERROR_MESSAGE,
                    'userInfos' => $userInfos,
                    'return' => true,
                ]);
            }
        }

        return $this->render('create_user.html.twig');
    }

    
    #[Route(path: '/user-success', name: 'user_success')]
    public function userSuccess(
        Request $request,
        UserService $userService
    ): Response
    { 
        $message = $request->query->get('success') ? SystemWording::SUCCESS_REGISTRATION : 'Keine Information';
        return $this->render('user_success.html.twig', [
            'message' => $message
        ]);
    }

}
