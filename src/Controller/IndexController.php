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

    #[Route(path: '/create-user', name: 'create-user')]
    public function createUser(
        Request $request,
        EntityManagerInterface $entityManager
    ): Response
    {
        return $this->render("createUser.html.twig");
    }



}
