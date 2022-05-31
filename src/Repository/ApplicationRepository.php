<?php

namespace App\Repository;

use App\Entity\Application;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Application|null find($id, $lockMode = null, $lockVersion = null)
 * @method Application|null findOneBy(array $criteria, array $orderBy = null)
 * @method Application[]    findAll()
 * @method Application[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ApplicationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Application::class);
    }

    public function findByEvent($eventId)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.happening = :eventId')
            ->setParameter('eventId', $eventId)
            ->getQuery()
            ->getResult();
    }

    public function findApprovedByEvent($eventId)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.happening = :eventId')
            ->andWhere('a.status = :status')

            ->setParameter('eventId', $eventId)
            ->setParameter('status', Application::STATUS_APPROVED)
            ->getQuery()
            ->getResult();
    }

    public function save(Application $application, bool $flush = true)
    {

        $this->_em->persist($application);
        if($flush){
            $this->_em->flush();
        }
    }
}
