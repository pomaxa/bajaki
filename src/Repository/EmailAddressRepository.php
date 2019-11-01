<?php

namespace App\Repository;

use App\Entity\EmailAddress;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method EmailAddress|null find($id, $lockMode = null, $lockVersion = null)
 * @method EmailAddress|null findOneBy(array $criteria, array $orderBy = null)
 * @method EmailAddress[]    findAll()
 * @method EmailAddress[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EmailAddressRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, EmailAddress::class);
    }
}
