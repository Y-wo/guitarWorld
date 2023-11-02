<?php

namespace App\Service;

use App\Entity\AbstractEntity;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

abstract class AbstractEntityService
{

    protected $entityManager;
    protected $slugger;

    public function __construct(EntityManagerInterface $entityManager, SluggerInterface $slugger)
    {
        $this->entityManager = $entityManager;
        $this->slugger = $slugger;
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

}