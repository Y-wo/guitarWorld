<?php

namespace App\Service;

use App\Entity\Guitar;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Service\GuitarTypeService;

class GuitarService extends AbstractEntityService
{

    private GuitarTypeService $guitarTypeService;

    public function __construct(EntityManagerInterface $entityManager, GuitarTypeService $guitarTypeService)
    {
        parent::__construct($entityManager);
        $this->guitarTypeService = $guitarTypeService;
    }

    public static $entityFqn = Guitar::class;


    /*
    * creates new guitar
    */
    public function createNewGuitar($infos) : bool 
    {
        $guitar = new Guitar();
        $guitarType = $this->guitarTypeService->get($infos['guitarTypeId']);

        $guitar
            ->setModel($infos['model'])
            ->setColor($infos['color'])
            ->setDeleted(0)
            ->setPrice($infos['price'])
            ->setUsed(0)
            ->setBody($infos['body'])
            ->setPickup($infos['pickup'])
            ->setGuitarType($guitarType)
            ;
        
        return $this->store($guitar) ? true : false;
    }


    /*
    * checks if guitar already exists
    */
    public function guitarExists(array $infos) : bool 
    {
        $query = $this
            ->entityManager
            ->getRepository(self::$entityFqn)
            ->createQueryBuilder('r')
            ->select('r')
            ->where('r.model = :model')
            ->andwhere('r.color = :color')
            ->andwhere('r.body = :body')
            ->andwhere('r.pickup = :pickup')
            ->setParameter('model', $infos['model'])
            ->setParameter('color', $infos['color'])
            ->setParameter('body', $infos['body'])
            ->setParameter('pickup', $infos['pickup'])
            ;

        $result = $query->getQuery()->execute();
        return count($result) > 0;   
    }

}