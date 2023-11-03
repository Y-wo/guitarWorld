<?php

namespace App\Service;

use App\Entity\Guitar;
use Doctrine\ORM\EntityManagerInterface;

class GuitarService extends AbstractEntityService
{
    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct($entityManager);
    }

    public static $entityFqn = Guitar::class;

}