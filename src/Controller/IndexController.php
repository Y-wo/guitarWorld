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
use App\Service\LoginService;
use DateTimeImmutable;
use Symfony\Component\Validator\Constraints\Date;

class IndexController extends AbstractController
{
    #[Route(path: '/', name: 'home')]
    public function home(   
        Request $request
    ): Response
    {   
        $message = $request->query->get('message') ?? null;
        $info1 = $request->query->get('info1') ?? null;
        $info2 = $request->query->get('info2') ?? null;
        $info3 = $request->query->get('info3') ?? null;

        $user = $request->getSession()->get('user') ?? null;

        return $this->render("base.html.twig", [
           'headline' => SystemWording::HELLO,
           'message' => $message,
        ]);
    }


    #[Route(path: '/login', name: 'login')]
    public function login(
        Request $request,
        LoginService $loginService,
    ): Response
    {
        $isAuthorized = $loginService->authenticate($request);
        $message = $isAuthorized ? SystemWording::SUCCESS_LOGIN : SystemWording::ERROR_LOGIN;
        return $this->redirectToRoute('home', [
            'message' => $message,
            'info1' => $request->getSession()->get('user') ?? 'kein User vorhanden'
        ]);
    }


    #[Route(path: '/logout', name: 'logout')]
    public function logout(
        Request $request,
        EntityManagerInterface $entityManager,
        LoginService $loginService,
        UserService $userService
    ): Response
    {
        $loginService->clearSession($request);
        return $this->redirectToRoute('home', [
            'message' => SystemWording::SUCCESS_LOGOUT
        ]);

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

    #[Route(path: '/create-guitar', name: 'create_guitar')]
    public function createGuitar(
        Request $request,
        UserService $userService
    ): Response
    { 
        return new Response("blablabla neue Gitarre");
        
    }

}
