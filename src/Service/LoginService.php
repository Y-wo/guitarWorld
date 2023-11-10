<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Constants\SystemWording;

class LoginService{

    private UserService $userService;
    private UserPasswordHasherInterface $passwordHasher;
    // private JwtService $jwtService;

    public function __construct(
        UserService $userService,
        UserPasswordHasherInterface $passwordHasher
        // JwtService $jwtService

    )
    {
        $this->userService = $userService;
        $this->passwordHasher = $passwordHasher;
        // $this->jwtService = $jwtService;
    }

    public function authenticate(
        Request $request
    ):bool
    {
        $sentIdentifier = $request->request->get('identifier');
        $sentPassword = $request->request->get('password');
        if(empty($sentIdentifier) || empty($sentPassword)) return false;
        $user = $this->userService->getUserByEmail($sentIdentifier);
        if(empty($user)) return false;
        $sentHashedPassword = hash('md5', $sentPassword);
        if($sentHashedPassword == $user->getPassword()){
            $this->storeAuthenticationSessionVariables($request, $user);
            return true;
        }
        return false;
    }


    public function storeAuthenticationSessionVariables(
        Request $request,
        User $user
    ) :void
    {
        $session = $request->getSession();
        $session->set('logged_in', true);
        $session->set('user', $user);
    }

    public function clearSession(
        Request $request
    ) :void
    {
        $session = $request->getSession();
        $session->clear();
    }

    public function isLoggedIn(Request $request)
    : bool
    {
        $session = $request->getSession();
        $state =  $session->get('loggedIn');
        if($state) return true;
        return false;
    }

}