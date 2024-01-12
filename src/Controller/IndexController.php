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
        Request $request,
        GuitarService $guitarService
    ): Response
    {   
        $message = $request->query->get('message') ?? null;

        $guitars = $guitarService->getAll();

        return $this->render("home.html.twig", [
           'headline' => SystemWording::HELLO,
           'message' => $message,
           'guitars' => $guitars ?? null
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
    ): Response
    { 
        $message = $request->query->get('success') ? SystemWording::SUCCESS_REGISTRATION : 'Keine Information';
        return $this->render('user_success.html.twig', [
            'message' => $message
        ]);
    }

    
    #[Route(path: '/create-guitar-type', name: 'create_guitar_type')]
    public function createGuitarType(
        Request $request,
        GuitarTypeService $guitarTypeService
    ): Response
    { 
        $isSubmit = $guitarTypeService->isSubmit($request);
        
        // process if input is submitted
        if ($isSubmit) {
            $guitarTypeInfos = $request->request->all();
            $guitarTypeExists = $guitarTypeService->guitarTypeExists($guitarTypeInfos['brand'], $guitarTypeInfos['version']);
            $messageAddition = '- Marke: ' .  $guitarTypeInfos['brand'] . '<br>- Typ: ' . $guitarTypeInfos['version'];
            if ($guitarTypeExists) {
                return $this->render('create_guitar_type.html.twig', [
                    'message' => SystemWording::GUITAR_TYPE_ALREADY_EXISTS . $messageAddition,
                    'guitarTypeInfos' => $guitarTypeInfos,
                    'return' => true,
                ]);
            }
            else {
                if ($guitarTypeService->createNewGuitarType($guitarTypeInfos)){
                    return $this->render('create_guitar_type.html.twig', [
                        'message' => SystemWording::SUCCESS_GUITAR_TYPE_CREATION . $messageAddition ,
                        'guitarTypeInfos' => $guitarTypeInfos,
                        'return' => false,
                    ]);
                }
                else {
                    return $this->render('create_guitar_type.html.twig', [
                        'message' => SystemWording::FAILURE_MESSAGE,
                        'guitarTypeInfos' => $guitarTypeInfos,
                        'return' => true,
                    ]);
                }
            }
        }
        return $this->render('create_guitar_type.html.twig', [
            'guitarTypeInfos' => null
        ]);
    }


    #[Route(path: '/create-guitar', name: 'create_guitar')]
    public function createGuitar(
        Request $request,
        GuitarService $guitarService,
        GuitarTypeService $guitarTypeService
    ): Response
    { 
        $isSubmit = $guitarService->isSubmit($request);
        $guitarTypes = $guitarTypeService->getAll();
        $message = $request->query->get('message') ?? null;

        // process if input is submitted
        if ($isSubmit) {
            $guitarInfos = $request->request->all();
            $guitarExists = $guitarService->guitarExists($guitarInfos);

            if($guitarExists){
                return $this->render('create_guitar.html.twig', [
                    'message' => SystemWording::GUITAR_ALREADY_EXISTS,
                    'infos' => $guitarInfos,
                    'guitarTypes' => $guitarTypes,
                    'return' => true,
                ]);
            }
            else {
                if ($guitarService->createNewGuitar($guitarInfos)){
                    return $this->render('create_guitar.html.twig', [
                        'message' => SystemWording::SUCCESS_GUITAR_CREATION,
                        'infos' => $guitarInfos,
                        'guitarTypes' => $guitarTypes,
                        'return' => false,
                    ]);
                }else{
                    return $this->render('create_guitar.html.twig', [
                        'message' => SystemWording::FAILURE_MESSAGE,
                        'infos' => $guitarInfos,
                        'guitarTypes' => $guitarTypes,
                        'return' => true,
                    ]);
                }
            }
        }

        return $this->render('create_guitar.html.twig', [
            'guitarTypes' => $guitarTypes,
            'message' => $message
        ]);
    }

    #[Route(path: '/upload-image', name: 'upload_image')]
    public function uploadImage(
        Request $request,
        ImageService $imageService
    ): Response
    {
        $isSubmit = $imageService->isSubmit($request);
        if ($isSubmit) {
            $uploadInfos = $imageService->uploadImage();

            var_dump($uploadInfos);

            // return $this->render('upload_image.html.twig');
            return $this->redirectToRoute('create_guitar', [
                'message' => $uploadInfos['message']
            ]);
        }

        return $this->render('upload_image.html.twig');
    }

}
