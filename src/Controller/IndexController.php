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
use LDAP\Result;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Constraints\Regex;

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



    /*
    * Create Guitar
    */
    #[Route(path: '/create-guitar', name: 'create_guitar')]
    public function createGuitar(
        Request $request,
        GuitarService $guitarService,
        GuitarTypeService $guitarTypeService,
        ImageGuitarService $imageGuitarService
    ): Response
    { 
        $session = $request->getSession();
        $session->set('guitar_manipulation_process', SystemWording::CREATE_GUITAR);

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

                $guitarUploadInfos = $guitarService->createNewGuitar($guitarInfos);

                if ($guitarUploadInfos['isUploadSuccessfull']){

                    //create new ImageGuitar-Entity
                    if(!empty($guitarUploadInfos['imageId'])){
                        $imageGuitarService
                            ->createNewImageGuitar(
                                $guitarUploadInfos['imageId'], 
                                $guitarUploadInfos['guitarId']
                            );
                    }
                   
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
            'message' => $message,
            'imageIsUploaded' => $request->query->get('isUploaded') ?? false,
            'targetFile' => $request->query->get('targetFile') ?? null
        ]);
    }


    /*
    * Change Guitar
    */
    #[Route(path: '/change-guitar', name: 'change_guitar')]
    public function changeGuitar(
        Request $request,
        GuitarService $guitarService,
        GuitarTypeService $guitarTypeService,
        ImageGuitarService $imageGuitarService,
        ImageService $imageService
    ): Response
    {
        $isSubmit = $guitarService->isSubmit($request);

        $message = $request->query->get('message') ?? null;

        $fileExists = $request->query->get('fileExists') ?? null;

        $guitarTypes = $guitarTypeService->getAll();
        $guitarId = $request->query->get('id');
        $guitar = $guitarService->get($guitarId);

        $session = $request->getSession();
        $session->set('guitar_manipulation_process', SystemWording::CHANGE_GUITAR);
        $session->set('guitar_id', $guitarId);

        $imageGuitar = $guitar->getImageGuitar()[0] ?? null;
        $targetFile = $imageGuitar ? $imageGuitar->getImage()->getName() : null;
        $targetFile = $request->query->get('targetFile') ?? $targetFile;

        if ($isSubmit){
            $guitarInfos = $request->request->all();
            $guitarUploadInfos = $guitarService->changeGuitar($guitarInfos);

            if ($guitarUploadInfos['isUploadSuccessfull']) {

                //create new ImageGuitar-Entity
                if(!empty($guitarUploadInfos['imageId'])) {
                    
                    $storedImage = $imageGuitar?->getImage() ?? null;
                    $storedImageId = $storedImage?->getId() ?? null;
                    
                    // check if image is new to guitar
                    if ($storedImageId !== $guitarUploadInfos['imageId']) {

                        if (!empty($storedImageId)) $imageGuitarService->remove($imageGuitar);

                        $imageGuitarId = $imageGuitarService
                            ->createNewImageGuitar(

                                // hier wird ne Image nicht ne id gegeben. 
                                $guitarUploadInfos['imageId'], 
                                $guitarId
                        );

                        $imageGuitar = $imageGuitarService->get($imageGuitarId);
                        $newTargetFile = $imageGuitar->getImage()->getName();
                        $targetFile = $newTargetFile;
                        }
                    }
                $message = SystemWording::SUCCESS_GUITAR_CHANGE;
            }
        }        

        $guitarInfos = [
            'id' => $guitar->getId(),
            'model' => $guitar->getModel(),
            'color' => $guitar->getColor(),
            'price' => $guitar->getPrice(),
            'body' => $guitar->getBody(),
            'pickup' => $guitar->getPickup(),
            'submit' => '',
            'guitarTypeId' => $guitar->getGuitarType()->getId(),
            'image' => $imageGuitar ? $imageGuitar->getImage()->getName() : null,
            'fileExists' => $fileExists
        ];

        return $this->render('change_guitar.html.twig', [
            'guitarTypes' => $guitarTypes,
            'return' => true,
            'infos' => $guitarInfos,
            'guitarChange' => true,
            'message' => $message,
            'targetFile' => $targetFile,
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

            if ($uploadInfos['isUploaded']){

                $session = $request->getSession();
                $redirection = $session->get('guitar_manipulation_process') ?? SystemWording::CREATE_GUITAR;

                $message = $uploadInfos['message'] ?? null;
                $isUploaded = $uploadInfos['isUploaded'];
                $targetFile = $uploadInfos['targetFile'];
                $fileExists = $uploadInfos['fileExists'];

                if ($redirection == SystemWording::CREATE_GUITAR) {
                    return $this->redirectToRoute('create_guitar', [
                        'message' => $message,
                        'isUploaded' => $isUploaded,
                        'targetFile' => $targetFile,
                        'fileExists' => $fileExists
                    ]);
                }
                else {
                    return $this->redirectToRoute('change_guitar', [
                        'message' => $message,
                        'isUploaded' => $isUploaded,
                        'targetFile' => $targetFile,
                        'id' => $session->get('guitar_id'),
                        'fileExists' => $fileExists
                    ]);
                }

            }
            return $this->render('upload_image.html.twig', [
                'message' => $uploadInfos['message']
            ]);
        
        }

        return $this->render('upload_image.html.twig');
    }

}
