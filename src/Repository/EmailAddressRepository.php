<?php

namespace App\Repository;

use App\Entity\EmailAddress;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;


/**
 * @method EmailAddress|null find($id, $lockMode = null, $lockVersion = null)
 * @method EmailAddress|null findOneBy(array $criteria, array $orderBy = null)
 * @method EmailAddress[]    findAll()
 * @method EmailAddress[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EmailAddressRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EmailAddress::class);
    }
}
