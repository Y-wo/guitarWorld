<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;

class LoginService{

    private UserService $userService;
    // private JwtService $jwtService;

    public function __construct(
        UserService $userService,
        // JwtService $jwtService

    )
    {
        $this->userService = $userService;
        // $this->jwtService = $jwtService;
    }

    public function authenticate(
        Request $request
    ):bool
    {
        $sentIdentifier = $request->request->get('identifier');
        $sentPassword = $request->request->get('password');

        $user = $this->userService->getUserByEmail($sentIdentifier);


        // HIER WEITER: getUserByEmail schreiben





        // if(!$member) {
        //     return false;
        // }

        // $isAdmin = $this->adminEntityService->isAdmin($member->getId());

        // if(!$isAdmin){
        //     return false;
        // }

        // $sentHashedPassword = hash('md5', $sentPassword);
        // $storedPassword = $this->adminEntityService->getPasswortByMemberId($sentMemberId);

        // if($sentHashedPassword == $storedPassword){
        //     $this->storeAuthenticationSessionVariables($request, $sentMemberId);
        //     return true;
        // }

        return false;
    }


    // public function storeAuthenticationSessionVariables(
    //     Request $request,
    //     int $memberId
    // ) :void
    // {
    //     /** @var MemberEntity $member */
    //     $member = $this->memberEntityService->get($memberId);
    //     $jwt = $this->jwtService->createJwt();
    //     $firstName = $member->getFirstName();
    //     $lastName = $member->getLastName();

    //     $session = $request->getSession();

    //     $session->set('jwt', $jwt);
    //     $session->set('memberId', $memberId);
    //     $session->set('firstName', $firstName);
    //     $session->set('lastName', $lastName);
    //     $session->set('loggedIn', true);
    // }

    // public function clearSession(
    //     Request $request
    // ) :void
    // {
    //     $session = $request->getSession();
    //     $session->clear();
    // }

    // public function isLoggedIn(Request $request)
    // : bool
    // {
    //     $session = $request->getSession();
    //     $state =  $session->get('loggedIn');
    //     if($state) return true;
    //     return false;
    // }

}