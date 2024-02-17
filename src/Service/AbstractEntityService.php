<?php

namespace App\Service;

use App\Entity\AbstractEntity;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

abstract class AbstractEntityService
{
    protected $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public static $entityFqn;

    public function get(int $id)
    : ?AbstractEntity
    {
        return $this
            ->entityManager
            ->getRepository(static::$entityFqn)
            ->find($id);
    }

    public function getAll()
    {
        return $this
            ->entityManager
            ->getRepository(static::$entityFqn)
            ->findAll();
    }

    public function getRepository(

    )
    {
        return $this->entityManager->getRepository(static::$entityFqn);
    }

    public function store(AbstractEntity $entity) : self
    {
        $this->entityManager->persist($entity);
        $this->entityManager->flush();
        return $this;
    }

    public function remove(AbstractEntity $entity) : self
    {
        $this->entityManager->remove($entity);
        $this->entityManager->flush();
        return $this;
    }

    public function isSubmit(Request $request) : bool 
    {
        return $request->request->get('submit') ? true : false;
    }

    /*
    * sets deleted true
    */
    public function setDeletedById(int $id) : bool 
    {
        $entity = $this->get($id);
        $entity->setDeleted(true);
        return ($this->store($entity)) ? true : false;   
    }

    
    /*
    * sets deleted false
    */
    public function setNotDeletedById(int $id) : bool 
    {
        $guitar = $this->get($id);
        $guitar->setDeleted(false);
        return ($this->store($guitar)) ? true : false;   
    }


    /*
    * gets all abstract entities where deleted != true
    */
    public function getAllNotDeleted() : array 
    {
        $queryBuilder = $this
            ->entityManager
            ->getRepository(static::$entityFqn)
            ->createQueryBuilder('r')
            ->select('r')
            ->where('r.deleted != true')
            ->orderBy('r.brand')
            ;

        return $queryBuilder->getQuery()->execute();
    }
}