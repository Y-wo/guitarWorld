<?php

namespace App\Controller;

use App\Constants\SystemWording;
use App\Constants\JsScripts;
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
use App\Service\LoginService;
use App\Service\OrderService;
use App\Service\RequestService;
use App\Service\HelperService;

class IndexController extends AbstractController
{
    #[Route(path: '/', name: 'home')]
    public function home(   
        Request $request,
        GuitarService $guitarService
    ): Response
    {   
        $isSubmit = $request->query->get('submit');
        $searchPhrase = $request->query->get('search-phrase');
        $message = $request->query->get('message') ?? null;
        $clearLocalStorage = $request->query->get('clearLocalStorage') ?? false;
        $localStorageScript = $clearLocalStorage ? JsScripts::CLEAR_LOCAL_STORAGE : null;

        // handling if guitar is searched
        if ($isSubmit && !empty($searchPhrase)) {
            $guitars = $guitarService->getAllByPhrase($searchPhrase, false, false);
            $message = (count($guitars) > 0) ?
                'Ergebnis der Suche "' .  $searchPhrase . '".'
                :
                'Leider wurde kein passendes Ergebnis gefunden.'
                ;  
        }   

        if (!$isSubmit || (count($guitars) <= 0)) {
            $guitars = $guitarService->getAllSelectedGuitars(false, false);
        }

        return $this->render("home.html.twig", [
           'headline' => SystemWording::HELLO,
           'message' => $message,
           'guitars' => $guitars ?? null,
           'localStorageScript' => $localStorageScript ?? null,
           'confirmationText' => SystemWording::GUITAR_DELETE_CONFIRMATION,
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

        // removes items from shopping-cart if admin is logged in
        $clearLocalStorage = $isAuthorized ? true : false;
        
        return $this->redirectToRoute('home', [
            'message' => $message,
            'clearLocalStorage' => $clearLocalStorage,
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

    #[Route(path: '/search', name: 'search')]
    public function search(
        Request $request,
        EntityManagerInterface $entityManager,
        GuitarService $guitarService
    ): Response
    {
        $searchPhrase = $request->query->get('search-phrase');

        $searchedGuitars = $guitarService->getAllByPhrase($searchPhrase, false, false);

        
        return $this->redirectToRoute('home', [
            'message' => 'Ergebnis der Suche "' .  $searchPhrase . '":',
            'searchedGuitars' => $searchedGuitars,
            'bla' => 'blubb'
        ]);

    }




    #[Route(path: '/guitar', name: 'guitar')]
    public function guitar(
        Request $request,
        GuitarService $guitarService
    ): Response
    {
        $guitarId = $request->query->get('guitarId') ?? null;
        $guitar = $guitarService->get($guitarId) ?? null;

        if(empty($guitar)) return $this->redirectToRoute('home', [
            'message' => SystemWording::NO_GUITAR_FOUND
        ]);

        return $this->render('guitar-detail.html.twig', [
            'guitar' => $guitar
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
        
        // process if new guitarType is submitted
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
    * gives guitartype overview
    */ 
    #[Route(path: '/guitar-type-overview', name: 'guitar_type_overview')]
    public function guitarTypeOverview(
        Request $request,
        GuitarTypeService $guitarTypeService
    ): Response
    { 
        $guitarTypes = $guitarTypeService->getAllNotDeleted();
        $message = $request->query->get('message') ?? null;

        return $this->render('guitar_type_overview.html.twig', [
            'guitarTypes' => $guitarTypes,
            'confirmationText' => SystemWording::GUITAR_TYPE_DELETE_CONFIRMATION,
            'message' => $message ?? ''
        ]);
    }



    /*
    * shows and changes guitarType by id
    */
    #[Route(path: '/change-guitar-type/{id}', name: 'change_guitar_type')]
    public function changeGuitarType(
        Request $request,
        GuitarTypeService $guitarTypeService,
        RequestService $requestService,
        int $id
    ): Response
    { 
        $isSubmit = $requestService->isSubmit($request);
        if ($isSubmit) {
            $guitarTypeService->changeGuitarType($id, $request);
            $message = SystemWording::GUITAR_TYPE_CHANGED;
        } 

        $guitarTypeArray = $guitarTypeService->createGuitarTypeInfoArray($id);

        return $this->render('change_guitar_type.html.twig', [
            'guitarTypeInfos' => $guitarTypeArray,
            'return' => true,
            'submit_label' => 'Speichern',
            'guitarTypeId' => $id,
            'message' => $message ?? ''
        ]);
    }



    /*
    * deletes guitarType by id
    */
    #[Route(path: '/delete-guitar-type/{id}', name: 'delete_guitar_type')]
    public function deleteGuitarType(
        Request $request,
        GuitarTypeService $guitarTypeService,
        GuitarService $guitarService,
        int $id
    ): Response
    { 
        $guitarService->setDeletedByGuitarTypeId($id);

        if($guitarTypeService->setDeletedbyId($id)) {
            $message = SystemWording::GUITAR_TYPE_DELETED . $id;
        } else {
            $message = SystemWording::ERROR_MESSAGE;
        }

        return $this->redirectToRoute('guitar_type_overview', [
            'message' => $message
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
        $processData = [];

        $session = $request->getSession();
        $session->set('guitar_manipulation_process', SystemWording::CREATE_GUITAR);

        $guitarInfos = $request->request->all();
        $isSubmit = $guitarService->isSubmit($request);
        $guitarTypes = $guitarTypeService->getAll();

        $pocessData['message'] = $request->query->get('message') ?? null;
        $processData['guitarTypes'] =  $guitarTypes;
        $processData['infos'] = $guitarInfos;
        $processData['imageIsUploaded'] = $request->query->get('isUploaded') ?? false;
        $processData['targetFile'] = $request->query->get('targetFile') ?? null;

        // process if new guitar is submitted
        if ($isSubmit) {
            $guitarExists = $guitarService->guitarExists($guitarInfos);

            // Does not create new guitar, if guitar already exists
            if($guitarExists){
                $processData['message'] = SystemWording::GUITAR_ALREADY_EXISTS;
                $processData['return'] = true;
            }

            // creates new guitar
            else {  
                $guitarUploadInfos = $guitarService->createNewGuitar($guitarInfos);
                if ($guitarUploadInfos['isUploadSuccessfull']){

                    //adds image to guitar
                    if(!empty($guitarUploadInfos['imageId'])){
                        $imageGuitarService
                            ->createNewImageGuitar(
                                $guitarUploadInfos['imageId'], 
                                $guitarUploadInfos['guitarId']
                            );
                    }   
                    $processData['message'] = SystemWording::SUCCESS_GUITAR_CREATION;
                    $processData['return'] = false;
                } 
                else {
                    $processData['message'] = SystemWording::FAILURE_MESSAGE;
                    $processData['return'] = true;
                }
            }
        }

        return $this->render('create_guitar.html.twig', $processData);
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
    ): Response
    {
        $isSubmit = $guitarService->isSubmit($request);
        $message = $request->query->get('message') ?? null;
        $fileExists = $request->query->get('fileExists') ?? null;
        $guitarTypes = $guitarTypeService->getAll();
        $guitarId = $request->query->get('id');
        $guitar = $guitarService->get($guitarId);

        // session variables for handling on following pages
        $session = $request->getSession();
        $session->set('guitar_manipulation_process', SystemWording::CHANGE_GUITAR);
        $session->set('guitar_id', $guitarId);

        $imageGuitar = $guitar->getImageGuitar()[0] ?? null;
        $targetFile = $imageGuitar ? $imageGuitar->getImage()->getName() : null;
        $targetFile = $request->query->get('targetFile') ?? $targetFile;

        // process if guitar-changes shall be changed
        if ($isSubmit){
            $guitarInfos = $request->request->all();
            $guitarChangeInfos = $guitarService->changeGuitar($guitarInfos);

            if ($guitarChangeInfos['isUploadSuccessfull']) {

                //add new Image to guitar
                if(!empty($guitarChangeInfos['imageId'])) {
                    
                    $storedImage = $imageGuitar?->getImage() ?? null;
                    $storedImageId = $storedImage?->getId() ?? null;
                    
                    // check if image is new to guitar
                    if ($storedImageId !== $guitarChangeInfos['imageId']) {

                        // remove last image by deletin the concerning imageGuitar-Entity
                        if (!empty($storedImageId)) $imageGuitarService->remove($imageGuitar);

                        $imageGuitarId = $imageGuitarService
                            ->createNewImageGuitar(
                                $guitarChangeInfos['imageId'], 
                                $guitarId
                        );

                        $imageGuitar = $imageGuitarService->get($imageGuitarId);
                        $targetFile = $imageGuitar->getImage()->getName();
                        // $targetFile = $newTargetFile;
                        }
                    }
                $message = SystemWording::SUCCESS_GUITAR_CHANGE;
            }
        }        

        // these infos are needed for the setInputField()-method in the following template
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
            'confirmationImageText' => SystemWording::IMAGE_DELETE_CONFIRMATION 
        ]);
    }

    
    /*
    * Delete Guitar Route
    */
    #[Route(path: '/delete-guitar', name: 'delete_guitar')]
    public function deleteGuitar(
        Request $request,
        GuitarService $guitarService
    ): Response
    {
        $guitarId = $request->query->get('id');
        $guitarService->setDeletedById($guitarId);
        $message = SystemWording::SUCCESS_GUITAR_DELETED . "(ID: " .$guitarId . ")";
        return $this->redirectToRoute('home', [
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



    /*
    * remove ImageGuitarEntity from Database
    */
    #[Route(path: '/remove-image-guitar', name: 'remove_image_guitar')]
    public function removeImageGuitar(
        Request $request,
        ImageService $imageService,
        GuitarService $guitarService,
        ImageGuitarService $imageGuitarService
    ): Response
    {
        $session = $request->getSession();
        $guitarId = $session->get('guitar_id');
        $guitar = $guitarService->get($guitarId);
        $imageGuitar = $guitar->getImageGuitar()[0] ?? null;

        if(!empty($imageGuitar)) $imageGuitarService->remove($imageGuitar);

        $redirection = $session->get('guitar_manipulation_process') ?? SystemWording::CREATE_GUITAR;
        return $this->redirectToRoute($redirection, [
            'message' => SystemWording::IMAGE_GUITAR_REMOVED,
            'id' => $session->get('guitar_id') ?? null,
        ]);
    }



    /*
    * shows the shopping cart and creates order
    */
    #[Route(path: '/shopping-cart', name: 'shopping_cart')]
    public function shoppingCart(
        Request $request,
        OrderService $orderService,
    ): Response
    {
        $isSubmit = $orderService->isSubmit($request);
        if ($isSubmit) {
            $orderInfos = $request->request->all();
            $result = $orderService->createOrder($orderInfos);
            $message = 'Bestellung erfolgreich: Bestellnummer ' . $result;
            $localStorageScript = JsScripts::CLEAR_LOCAL_STORAGE;

            return $this->redirectToRoute('home', [
                'message' => $message,
                'clearLocalStorage' => true,
            ]);

        }

        return $this->render('shopping-cart.html.twig', [
            'message' => $message ?? null,
            'orderInfos' => $orderInfos ?? null,
            'localStorageScript' => $localStorageScript ?? null
        ]);
    }

    /*
    * shows orders and handles order-management
    */
    #[Route(path: '/orders', name: 'orders')]
    public function orders(
        Request $request,
        OrderService $orderService,
    ): Response
    {
        $orders = $orderService->getAllSortByDate(false);
        $isSubmit = $orderService->isSubmit($request);

        if ($isSubmit) {
            $orderChangeInfos = $request->request->all();

            // handles handling of order-state 
            if (!empty($orderChangeInfos['paidId'])) {
                $orderService->switchPaid($orderChangeInfos['paidId'], true);
            } 
            else if (!empty($orderChangeInfos['resetPaidId'])) {
                $orderService->switchPaid($orderChangeInfos['resetPaidId'], false);
            } 
            else if (!empty($orderChangeInfos['canceledId'])) {
                $orderService->switchCanceled($orderChangeInfos['canceledId'], true);
            }
            else if (!empty($orderChangeInfos['resetCanceledId'])) {
                $orderService->switchCanceled($orderChangeInfos['resetCanceledId'], false);
            }
        }

        return $this->render('orders.html.twig', [
            'orders' => $orders,
        ]);

    }

    /*
    * creates and downloads invoice of order
    */
    #[Route(path: '/invoice', name: 'invoice')]
    public function invoice(
        Request $request,
        OrderService $orderService
    ): Response
    {
        $orderId = $request->request->get('id');
        $orderService->provideInvoice($orderId);
        return $this->redirectToRoute('home', [
            'message' => SystemWording::ERROR_MESSAGE
        ]);
    }



    /*
    * test
    */
    #[Route(path: '/test', name: 'test')]
    public function test(
        Request $request,
        OrderService $orderService,
        GuitarService $guitarService
    ): Response
    {


        $myfile = fopen("invoices/newfile.txt", "w") or die("Unable to open file!");
        $txt = "John Doe test123\n";
        fwrite($myfile, $txt);
        $txt = "Jane Doe\n";
        fwrite($myfile, $txt);
        fclose($myfile);

        $file_url = 'http://localhost/guitarWorld/public/invoices/newfile.txt';
        // header('Content-Type: application/octet-stream');
        // header("Content-Transfer-Encoding: Binary"); 
        header("Content-disposition: attachment; filename=\"" . basename($file_url) . "\""); 
        readfile($file_url);
        exit(); 





        // $order = $orderService->get(35);
        // $test = $guitarService->getAllByOrderId(35);
        // // $test = $orderService->get(23);
        return $this->render('test.html.twig', [
            'test' => $test ?? ''
        ]);
    }

}
