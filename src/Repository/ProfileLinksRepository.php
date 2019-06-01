<?php

namespace App\Repository;

use App\Entity\ProfileLinks;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ProfileLinks|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProfileLinks|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProfileLinks[]    findAll()
 * @method ProfileLinks[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProfileLinksRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ProfileLinks::class);
    }

    // /**
    //  * @return ProfileLinks[] Returns an array of ProfileLinks objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ProfileLinks
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
