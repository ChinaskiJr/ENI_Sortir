<?php

namespace App\Repository;

use App\Entity\Pursuit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Pursuit|null find($id, $lockMode = null, $lockVersion = null)
 * @method Pursuit|null findOneBy(array $criteria, array $orderBy = null)
 * @method Pursuit[]    findAll()
 * @method Pursuit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PursuitRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Pursuit::class);
    }

    // /**
    //  * @return Pursuit[] Returns an array of Pursuit objects
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
    public function findOneBySomeField($value): ?Pursuit
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
