<?php

namespace App\Service;

use App\Entity\ImageGuitar;
use Doctrine\ORM\EntityManagerInterface;

class ImageGuitarService extends AbstractEntityService
{
    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct($entityManager);
    }

    public static $entityFqn = ImageGuitar::class;

}