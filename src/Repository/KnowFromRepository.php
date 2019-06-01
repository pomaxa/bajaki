<?php

namespace App\Repository;

use App\Entity\KnowFrom;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method KnowFrom|null find($id, $lockMode = null, $lockVersion = null)
 * @method KnowFrom|null findOneBy(array $criteria, array $orderBy = null)
 * @method KnowFrom[]    findAll()
 * @method KnowFrom[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class KnowFromRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, KnowFrom::class);
    }

    // /**
    //  * @return KnowFrom[] Returns an array of KnowFrom objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('k')
            ->andWhere('k.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('k.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?KnowFrom
    {
        return $this->createQueryBuilder('k')
            ->andWhere('k.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
