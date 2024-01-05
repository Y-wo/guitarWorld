<?php

namespace App\Service;

use App\Entity\GuitarType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class GuitarTypeService extends AbstractEntityService
{
    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct($entityManager);
    }

    public static $entityFqn = GuitarType::class;

    public function guitarTypeExists(string $brand, string $version) : bool 
    {
        $query = $this
            ->entityManager
            ->getRepository(self::$entityFqn)
            ->createQueryBuilder('r')
            ->select('r')
            ->where('r.brand = :brand')
            ->andwhere('r.version = :version')
            ->setParameter('brand', $brand)
            ->setParameter('version', $version)
            ;

        $result = $query->getQuery()->execute();
        return count($result) > 0;   
    }


    public function createNewGuitarType(array $infos) : bool
    {
        $guitarType = new GuitarType();
        
        $guitarType 
            ->setVersion($infos['version'])
            ->setBrand($infos['brand'])
            ->setType($infos['type'])
            ->setSaddlewidth($infos['saddlewidth'])
            ->setDeleted(0)
            ->setNeck($infos['neck'])
            ->setSize($infos['size'])
            ->setFretboard($infos['fretboard'])
            ->setScale($infos['scale'])
            ;

        return $this->store($guitarType) ? true : false;
    }
}