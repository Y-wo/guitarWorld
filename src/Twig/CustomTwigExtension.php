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
            new TwigFunction('setInputField', [$this, 'setInputField'])
        ];
    }

    public function getUser(Request $request)
    {
        return $request->getSession()->get('user') ?? null;
    }


    /*
    * checks if user is admin
    */
    public function isAdmin(User $user)
    {
        $roles = $user->getRoles();
        if(in_array(SystemWording::ROLE_ADMIN, $roles)) return true;
        return false;
    }

    /*
    * sets input fields in twig templates
    */
    public function setInputField(
        string $type, 
        string $name, 
        string $label, 
        ?array $infos, 
        bool $return,
        bool $isRequired = true,
        bool $hidden = false
        )
    {
        $attributes = $isRequired ? 'required' : '';
        $attributes .= $hidden ? 'hidden' : '';
        $asterisk = $isRequired ? '*' : '';
        $value = '';
        if ($return) $value = "value='$infos[$name]'";
        if ($name == 'submit') $value = "value=submit";

        return "
        <input type='$type' name='$name' $value $attributes>
        <label for='$name'> $label $asterisk </label>
        ";
        
    }
}
