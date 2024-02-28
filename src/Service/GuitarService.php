<?php

namespace App\Service;

use App\Entity\Guitar;
use Doctrine\ORM\EntityManagerInterface;
use App\Service\GuitarTypeService;
use App\Service\ImageService;

class GuitarService extends AbstractEntityService
{

    private GuitarTypeService $guitarTypeService;
    private ImageService $imageService;

    public function __construct(EntityManagerInterface $entityManager, GuitarTypeService $guitarTypeService, ImageService $imageService)
    {
        parent::__construct($entityManager);
        $this->guitarTypeService = $guitarTypeService;
        $this->imageService = $imageService;
    }

    public static $entityFqn = Guitar::class;


    /*
    * creates new guitar
    */
    public function createNewGuitar($infos) : array 
    {
        $guitar = new Guitar();
        $guitarType = $this->guitarTypeService->get($infos['guitarTypeId']);
        $imageId = null;
        $isUploadSuccessfull = false;

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

        if (!empty($infos['image'])) {
            //create Image-Entity
            $imageId = $this->imageService->getImageByName($infos['image'])->getId();
        }
        
        if($this->store($guitar)) $isUploadSuccessfull = true;

        $guitarUploadInfos = [
            'imageId' => $imageId,
            'guitarId' => $guitar->getId() ?? null,
            'isUploadSuccessfull' => $isUploadSuccessfull
        ];

        return $guitarUploadInfos;
    }


    /*
    * change Guitar
    */
    public function changeGuitar(array $infos) : array 
    {
        $guitar = $this->get($infos['id']);
        $guitarType = $this->guitarTypeService->get($infos['guitarTypeId']);
        $imageId = null;

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

        if (!empty($infos['image'])) {

            if (!empty($infos['fileExists']) && $infos['fileExists'] == true) {
                $imageId = $this->imageService->getImageByName($infos['image'])->getId();
            } 
            else {
                //create Image-Entity   
                $imageId = $this->imageService->getImageByName($infos['image'])->getId();
            }
        }

        if($this->store($guitar)) $isUploadSuccessfull = true;

        $guitarUploadInfos = [
            'imageId' => $imageId,
            'guitarId' => $infos['id'],
            'isUploadSuccessfull' => $isUploadSuccessfull,
            'fileExists' => $infos['fileExists'] ?? null
        ];

        return $guitarUploadInfos;
    }


    /*
    * checks if guitar already exists
    */
    public function guitarExists(array $infos) : bool 
    {
        $queryBuilder = $this
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

        $result = $queryBuilder->getQuery()->execute();
        return count($result) > 0;   
    }



    /*
    * sets all guitars deleted true by guitarTypeId
    */
    public function setDeletedByGuitarTypeId(int $id) : void 
    {
        $guitarType = $this->guitarTypeService->get($id);
        $guitarTypesGuitars = $guitarType->getGuitar()->toArray();
        if (!empty($guitarTypesGuitars)) {
            foreach ($guitarTypesGuitars as $guitar) {
                $this->setDeletedById($guitar->getId());  
            }
        }
    }




    /*
    * create query which queries all guitars
    */
    public function createQueryBuilder() {
        $queryBuilder = $this
            ->entityManager
            ->getRepository(self::$entityFqn)
            ->createQueryBuilder('r')
            ->select('r')
            ;

        return $queryBuilder;
    }



    /*
    * adds criteria to query
    */
    public function addCriteriaToQueryBuilder($queryBuilder, bool $deletedIncluded, bool $orderedIncluded) {
        if (!$deletedIncluded) {
            $queryBuilder
                ->where('r.deleted = false')
                ;
        }

        if (!$orderedIncluded) {
            $queryBuilder
                ->andWhere('r.guitarOrder is null')
                ;
        }

        return $queryBuilder;
    }



    /*
    * selects guitars according to criteria
    */
    public function getAllSelectedGuitars(bool $deletedIncluded, bool $orderedIncluded) : array 
    {
        $queryBuilder = $this->createQueryBuilder();
        $queryBuilder = $this->addCriteriaToQueryBuilder($queryBuilder, $deletedIncluded, $orderedIncluded);
        return $queryBuilder->getQuery()->execute();
    }


    
    /*
    * search guitar by phrase
    */
    public function getAllByPhrase(string $phrase, bool $deletedIncluded, bool $orderedIncluded) : array 
    {
        $queryBuilder = $this->createQueryBuilder();
        $queryBuilder = $this->addCriteriaToQueryBuilder($queryBuilder, $deletedIncluded, $orderedIncluded);
        $queryBuilder
            ->innerJoin('r.GuitarType', 'gt')
            ->where('
            r.model LIKE :phrase OR
            gt.version LIKE :phrase OR
            gt.brand LIKE :phrase OR 
            gt.type LIKE :phrase
            ')
            ->setParameter('phrase', '%' . $phrase . '%')
            ;

        return $queryBuilder->getQuery()->execute();
    }




    /*
    * gets guitar by id
    */
    public function getAllByOrderId($id) 
    {
        $queryBuilder = $this
            ->entityManager
            ->getRepository(self::$entityFqn)
            ->createQueryBuilder('r')
            ->select('r')
            ->where('r.guitarOrder = :order')
            ->setParameter('order', $id)
            ;

        return $queryBuilder->getQuery()->execute();
    }


}