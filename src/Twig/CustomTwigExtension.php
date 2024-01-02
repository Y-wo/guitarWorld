<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\User;
use App\Constants\SystemWording;

class CustomTwigExtension extends AbstractExtension
{
    public function getFunctions()
    {
        return [
            new TwigFunction('getUser', [$this, 'getUser']),
            new TwigFunction('isAdmin', [$this, 'isAdmin']),
        ];
    }

    public function getUser(Request $request)
    {
        return $request->getSession()->get('user') ?? null;
    }

    public function isAdmin(User $user)
    {
        $roles = $user->getRoles();
        if(in_array(SystemWording::ROLE_ADMIN, $roles)) return true;
        return false;
    }
}
