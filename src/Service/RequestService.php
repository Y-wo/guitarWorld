<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\Request;

class RequestService
{
    /*
    * checks if form is submit by checking a hidden sent field 'submit'
    */
    public function isSubmit(Request $request, string $method = 'post') : bool 
    {
        $isSubmit = false;
        if ($method == 'post') {
            $isSubmit = $request->request->get('submit') ? true : false;
        }
        else if ($method == 'get') {
            $isSubmit = $request->query->get('submit') ? true : false;
        }
        return $isSubmit;
    }
}