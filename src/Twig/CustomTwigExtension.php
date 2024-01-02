<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;
use Symfony\Component\HttpFoundation\Request;

class CustomTwigExtension extends AbstractExtension
{
    public function getFunctions()
    {
        return [
            new TwigFunction('getUser', [$this, 'getUser']),
        ];
    }

    public function getUser(Request $request)
    {
        return $request->getSession()->get('user') ?? null;
    }
}
