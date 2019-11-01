<?php

namespace App\Repository;

use App\Entity\Attender;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Attender|null find($id, $lockMode = null, $lockVersion = null)
 * @method Attender|null findOneBy(array $criteria, array $orderBy = null)
 * @method Attender[]    findAll()
 * @method Attender[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AttenderRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Attender::class);
    }
}
