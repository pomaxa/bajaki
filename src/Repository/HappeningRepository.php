<?php

namespace App\Repository;

use App\Entity\Happening;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Types\BooleanType;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Happening|null find($id, $lockMode = null, $lockVersion = null)
 * @method Happening|null findOneBy(array $criteria, array $orderBy = null)
 * @method Happening[]    findAll()
 * @method Happening[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HappeningRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Happening::class);
    }

    public function getUpcomming($limit)
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.isRegistrationOpen = :val')
            ->setParameter('val', true, BooleanType::BOOLEAN)
            ->orderBy('h.startsAt', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
            ;
    }

    // /**
    //  * @return Happening[] Returns an array of Happening objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('h.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Happening
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
