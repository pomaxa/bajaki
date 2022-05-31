<?php

namespace App\Repository;

use App\Entity\Happening;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Happening|null find($id, $lockMode = null, $lockVersion = null)
 * @method Happening|null findOneBy(array $criteria, array $orderBy = null)
 * @method Happening[]    findAll()
 * @method Happening[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HappeningRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Happening::class);
    }

    public function save(Happening $happening, $flush = true)
    {
        $this->_em->persist($happening);
        if($flush) {
            $this->_em->flush();
        }
    }

    public function getUpcomming(int $limit = 10)
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.isRegistrationOpen = :val')
            ->setParameter('val', true)
            ->orderBy('h.startsAt', 'ASC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult()
            ;
    }
}
