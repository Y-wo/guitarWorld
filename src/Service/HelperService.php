<?php

namespace App\Service;


class HelperService extends AbstractEntityService
{
    /*
    * converts string to array
    */
    public function stringToArray($string) : ?array 
    {
        return explode(',', $string);
    }   

}