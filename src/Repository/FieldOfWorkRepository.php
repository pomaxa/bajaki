<?php

namespace App\Repository;

use App\Entity\FieldOfWork;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method FieldOfWork|null find($id, $lockMode = null, $lockVersion = null)
 * @method FieldOfWork|null findOneBy(array $criteria, array $orderBy = null)
 * @method FieldOfWork[]    findAll()
 * @method FieldOfWork[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FieldOfWorkRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FieldOfWork::class);
    }

    // /**
    //  * @return FieldOfWork[] Returns an array of FieldOfWork objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?FieldOfWork
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
