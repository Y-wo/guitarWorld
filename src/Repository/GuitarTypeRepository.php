<?php

namespace App\Repository;

use App\Entity\GuitarType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<GuitarType>
 *
 * @method GuitarType|null find($id, $lockMode = null, $lockVersion = null)
 * @method GuitarType|null findOneBy(array $criteria, array $orderBy = null)
 * @method GuitarType[]    findAll()
 * @method GuitarType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GuitarTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GuitarType::class);
    }

//    /**
//     * @return GuitarType[] Returns an array of GuitarType objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('g')
//            ->andWhere('g.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('g.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?GuitarType
//    {
//        return $this->createQueryBuilder('g')
//            ->andWhere('g.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
