<?php

namespace App\Controller;

use App\Constants\SystemWording;
use App\Constants\JsScripts;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\UserService;
use App\Service\GuitarService;
use App\Service\GuitarTypeService;
use App\Service\ImageGuitarService;
use App\Service\ImageService;
use App\Service\LoginService;
use App\Service\OrderService;
use App\Service\RequestService;

class IndexController extends AbstractController
{

    /*
    * Home-controller: Shows all guitars
    */
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

        $guitars = $guitarService->getAllSelectedGuitars(false, false);

        // handling if guitar is searched
        if ($isSubmit && !empty($searchPhrase)) {
            $guitars = $guitarService->getAllByPhrase($searchPhrase, false, false);
            $message = (count($guitars) > 0) ?
                'Ergebnis der Suche "' .  $searchPhrase . '".'
                :
                'Leider wurde kein passendes Ergebnis gefunden.'
                ;  

            if (empty($guitars)) {
                $guitars = $guitarService->getAllSelectedGuitars(false, false);
            }   
        }   

        // This is needed for aligning the last guitar correctly
        $guitarsModuloResult = count($guitars) % 3;

        return $this->render("home.html.twig", [
           'headline' => SystemWording::HELLO,
           'message' => $message,
           'guitars' => $guitars ?? null,
           'localStorageScript' => $localStorageScript ?? null,
           'confirmationText' => SystemWording::GUITAR_DELETE_CONFIRMATION,
           'guitarsModuloResult' => $guitarsModuloResult
        ]);
    }


    /*
    * Authenticates User-Login-Data
    */
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


    /*
    * Logs user out by clearing the necessary session-variables 
    */
    #[Route(path: '/logout', name: 'logout')]
    public function logout(
        Request $request,
        LoginService $loginService,
    ): Response
    {
        $loginService->clearSession($request);
        return $this->redirectToRoute('home', [
            'message' => SystemWording::SUCCESS_LOGOUT
        ]);

    }


    /*
    * Searches guitar by transfered search-phrase
    */
    #[Route(path: '/search', name: 'search')]
    public function search(
        Request $request,
        GuitarService $guitarService
    ): Response
    {
        $searchPhrase = $request->query->get('search-phrase');

        $searchedGuitars = $guitarService->getAllByPhrase($searchPhrase, false, false);
        
        return $this->redirectToRoute('home', [
            'message' => 'Ergebnis der Suche "' .  $searchPhrase . '":',
            'searchedGuitars' => $searchedGuitars,
        ]);

    }



    /*
    * Shows guitar-data
    */
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



    /*
    * Creates new User and checks if user does not already exist
    */
    #[Route(path: '/create-user', name: 'create_user')]
    public function createUser(
        Request $request,
        UserService $userService,
        LoginService $loginService
    ): Response
    {      
        if (!$loginService->isAdminLoggedIn($request)){
            return $this->redirectToRoute('home');
        }

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




    /*
    * Rendered if User-Registration was successfull
    */
    #[Route(path: '/user-success', name: 'user_success')]
    public function userSuccess(
        Request $request,
        LoginService $loginService
    ): Response
    { 
        if (!$loginService->isAdminLoggedIn($request)){
            return $this->redirectToRoute('home');
        }

        $message = $request->query->get('success') ? SystemWording::SUCCESS_REGISTRATION : 'Keine Information';
        return $this->render('user_success.html.twig', [
            'message' => $message
        ]);
    }

    

    /*
    * Creates new guitar-type, if guitar-type does not already exist
    */
    #[Route(path: '/create-guitar-type', name: 'create_guitar_type')]
    public function createGuitarType(
        Request $request,
        GuitarTypeService $guitarTypeService,
        LoginService $loginService
    ): Response
    { 
        if (!$loginService->isAdminLoggedIn($request)){
            return $this->redirectToRoute('home');
        }

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
    * Gives overview of guitar-types
    */ 
    #[Route(path: '/guitar-type-overview', name: 'guitar_type_overview')]
    public function guitarTypeOverview(
        Request $request,
        GuitarTypeService $guitarTypeService,
        LoginService $loginService
    ): Response
    { 
        if (!$loginService->isAdminLoggedIn($request)){
            return $this->redirectToRoute('home');
        }

        $guitarTypes = $guitarTypeService->getAllNotDeleted();
        $message = $request->query->get('message') ?? null;

        return $this->render('guitar_type_overview.html.twig', [
            'guitarTypes' => $guitarTypes,
            'confirmationText' => SystemWording::GUITAR_TYPE_DELETE_CONFIRMATION,
            'message' => $message ?? ''
        ]);
    }



    /*
    * Shows and changes guitarType by id
    */
    #[Route(path: '/change-guitar-type/{id}', name: 'change_guitar_type')]
    public function changeGuitarType(
        Request $request,
        GuitarTypeService $guitarTypeService,
        RequestService $requestService,
        LoginService $loginService,
        int $id,
    ): Response
    { 
        if (!$loginService->isAdminLoggedIn($request)){
            return $this->redirectToRoute('home');
        }

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
    * Deletes guitarType by id
    */
    #[Route(path: '/delete-guitar-type/{id}', name: 'delete_guitar_type')]
    public function deleteGuitarType(
        Request $request,
        GuitarTypeService $guitarTypeService,
        GuitarService $guitarService,
        LoginService $loginService,
        int $id
    ): Response
    { 
        if (!$loginService->isAdminLoggedIn($request)){
            return $this->redirectToRoute('home');
        }

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
    * Creates new Guitar
    */
    #[Route(path: '/create-guitar', name: 'create_guitar')]
    public function createGuitar(
        Request $request,
        GuitarService $guitarService,
        GuitarTypeService $guitarTypeService,
        ImageGuitarService $imageGuitarService,
        LoginService $loginService
    ): Response
    { 
        if (!$loginService->isAdminLoggedIn($request)){
            return $this->redirectToRoute('home');
        }

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
    * Changes Guitar
    */
    #[Route(path: '/change-guitar', name: 'change_guitar')]
    public function changeGuitar(
        Request $request,
        GuitarService $guitarService,
        GuitarTypeService $guitarTypeService,
        ImageGuitarService $imageGuitarService,
        LoginService $loginService
    ): Response
    {
        if (!$loginService->isAdminLoggedIn($request)){
            return $this->redirectToRoute('home');
        }

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
    * Deletes Guitar Route
    */
    #[Route(path: '/delete-guitar', name: 'delete_guitar')]
    public function deleteGuitar(
        Request $request,
        GuitarService $guitarService,
        LoginService $loginService
    ): Response
    {
        if (!$loginService->isAdminLoggedIn($request)){
            return $this->redirectToRoute('home');
        }

        $guitarId = $request->query->get('id');
        $guitarService->setDeletedById($guitarId);
        $message = SystemWording::SUCCESS_GUITAR_DELETED . "(ID: " .$guitarId . ")";
        return $this->redirectToRoute('home', [
            'message' => $message
        ]);
    }
    


    /*
    * Uploads Image if image does not already exist. 
    * Creates link between image and guitar
    */
    #[Route(path: '/upload-image', name: 'upload_image')]
    public function uploadImage(
        Request $request,
        ImageService $imageService, 
        LoginService $loginService
    ): Response
    {
        if (!$loginService->isAdminLoggedIn($request)){
            return $this->redirectToRoute('home');
        }

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
    * Removes ImageGuitarEntity from Database
    */
    #[Route(path: '/remove-image-guitar', name: 'remove_image_guitar')]
    public function removeImageGuitar(
        Request $request,
        GuitarService $guitarService,
        ImageGuitarService $imageGuitarService,
        LoginService $loginService
    ): Response 
    {
        if (!$loginService->isAdminLoggedIn($request)){
            return $this->redirectToRoute('home');
        }

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
    * Shows the shopping cart and creates order
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
    * Shows orders and handles order-management
    */
    #[Route(path: '/orders', name: 'orders')]
    public function orders(
        Request $request,
        OrderService $orderService,
        LoginService $loginService
    ): Response
    {
        if (!$loginService->isAdminLoggedIn($request)){
            return $this->redirectToRoute('home');
        }

        $orders = $orderService->getAllSortByDate(false);
        $message = $request->query->get('message') ?? null;

        // Handles Order-/User-search
        $isSearchSubmit = $request->query->get('submit');
        $searchPhrase = $request->query->get('search-phrase');
        if ($isSearchSubmit && !empty($searchPhrase)) {
            $orders = $orderService->getAllByPhrase($searchPhrase);
            $message = (count($orders) > 0) ?
                'Ergebnis der Suche "' .  $searchPhrase . '".'
                :
                'Leider wurde kein passendes Ergebnis gefunden.'
                ;  
        }
        
        
        // Handles invoice-manipulation-actions
        $isActionSubmit = $orderService->isSubmit($request);
        if ($isActionSubmit) {
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
            'message' => $message ?? null,
        ]);

    }

    /*
    * Creates and downloads invoice of order
    */
    #[Route(path: '/invoice', name: 'invoice')]
    public function invoice(
        Request $request,
        OrderService $orderService,
        LoginService $loginService
    ): Response
    {
        if (!$loginService->isAdminLoggedIn($request)){
            return $this->redirectToRoute('home');
        }

        $orderId = $request->request->get('id');
        $orderService->provideInvoice($orderId);
        return $this->redirectToRoute('home', [
            'message' => SystemWording::ERROR_MESSAGE
        ]);
    }




    /*
    * Footer AGB
    */
    #[Route(path: '/footer-agb', name: 'footer_agb')]
    public function footerAgb(
        Request $request,
    ): Response
    {
        return $this->render('footer/footer_agb.html.twig');
    }



    /*
    * Footer Impressum
    */
    #[Route(path: '/footer-impressum', name: 'footer_impressum')]
    public function footerImpressum(
        Request $request,
    ): Response
    {
        return $this->render('footer/footer_impressum.html.twig');
    }



    /*
    * Footer Datenschutz
    */
    #[Route(path: '/footer-datenschutz', name: 'footer_datenschutz')]
    public function footerData(
        Request $request,
    ): Response
    {
        return $this->render('footer/footer_datenschutz.html.twig');
    }
}
