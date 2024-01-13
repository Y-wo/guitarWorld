<?php

namespace App\Service;

use App\Entity\ImageGuitar;
use Doctrine\ORM\EntityManagerInterface;
use App\Service\GuitarService;

class ImageGuitarService extends AbstractEntityService
{

    private ImageService $imageService;
    private GuitarService $guitarService;

    public function __construct(
        EntityManagerInterface $entityManager, 
        ImageService $imageService,
        GuitarService $guitarService
    )
    {
        parent::__construct($entityManager);
        $this->imageService = $imageService;
        $this->guitarService = $guitarService;
    }

    public static $entityFqn = ImageGuitar::class;


    /*
    * creates new ImageGuitar
    */
    public function createNewImageGuitar($imageId, $guitarId) : ?int 
    {
        $imageGuitar = new ImageGuitar();
        $image = $this->imageService->get($imageId);
        $guitar = $this->guitarService->get($guitarId);

        $imageGuitar
            ->setImage($image)
            ->setGuitar($guitar)
            ;
    
        return $this->store($imageGuitar) ? $imageGuitar->getId() : null;
    }
}