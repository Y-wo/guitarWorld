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


    #[Route(path: '/', name: 'test')]
    public function test(
        Request $request,
        EntityManagerInterface $entityManager
    ): Response
    {


        
        return $this->render("base.html.twig", [
            'item' => $item ??  "no item body blabla"
        ]);
    }



    #[Route(path: '/bla', name: 'bla')]
    public function bla(
        Request $request,
        UserService $userService,
        GuitarService $guitarService,
        GuitarTypeService $guitarTypeService,
        ImageGuitarService $imageGuitarService,
        ImageService $imageService,
        OrderService $orderService,
    ): Response
    {
        return $this->render("base.html.twig", [
            'body' => $item ??  "no item body blabla"
        ]);
    }


}
