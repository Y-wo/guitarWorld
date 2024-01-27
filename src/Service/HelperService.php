<?php

namespace App\Service;


class HelperService extends AbstractEntityService
{

    // public function __construct(
    //     EntityManagerInterface $entityManager, 
    // )
    // {
    //     parent::__construct($entityManager);
    // }



    /*
    * converts string to array
    */
    public function stringToArray($string) : ?array 
    {
        return explode(',', $string);
    }

    

}