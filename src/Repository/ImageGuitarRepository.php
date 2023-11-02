<?php

namespace App\Repository;

use App\Entity\ImageGuitar;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ImageGuitar>
 *
 * @method ImageGuitar|null find($id, $lockMode = null, $lockVersion = null)
 * @method ImageGuitar|null findOneBy(array $criteria, array $orderBy = null)
 * @method ImageGuitar[]    findAll()
 * @method ImageGuitar[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ImageGuitarRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ImageGuitar::class);
    }

//    /**
//     * @return ImageGuitar[] Returns an array of ImageGuitar objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('i.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ImageGuitar
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
