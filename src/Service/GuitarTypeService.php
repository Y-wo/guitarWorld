<?php

namespace App\Service;

use App\Entity\GuitarType;
use Doctrine\ORM\EntityManagerInterface;

class GuitarTypeService extends AbstractEntityService
{
    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct($entityManager);
    }

    public static $entityFqn = GuitarType::class;

}