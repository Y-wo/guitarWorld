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
        $userManipulationProcess = $userService->getUserManipulationProcess($request);

        // process, if form ist submitted
        if($userManipulationProcess == 'create_new_user'){
            $userInfos = $userService->createRequestUserAssociativeArray($request);
            if($userService->emailExists($userInfos['email'], true)){   
                $message = 'Die E-Mail "'. $userInfos['email'] . '" existiert bereits';
                return $this->render('create_user.html.twig', [
                    'message' => $message,
                    'userInfos' => $userInfos,
                    'return' => true,
                ]);
            }
            if($userInfos['email'] !== $userInfos['email_confirmation'] || $userInfos['password'] !== $userInfos['password_confirmation']){
                $message = 'E-Mail oder Passwort stimmen nicht überein';
                return $this->render('create_user.html.twig', [
                    'message' => $message,
                    'userInfos' => $userInfos,
                    'return' => true,
                ]);
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

            if($userService->store($user)){
                return $this->redirectToRoute('user_success', [
                    'message' => SystemWording::REGISTRATION_SUCCESS,
                ]);

            }else{
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
        $message = $request->query->get('message');
        return $this->render('user_success.html.twig', [
            'message' => $message ?? 'Keine Information'
        ]);
    }

}
