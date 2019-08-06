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

    /**
     * Performs DQL query to get every pursuits from a site, except the archived one
     *
     * @param $site
     * @param $archivedState
     * @return mixed
     */
    public function findAllPursuitsUnarchivedBysite($site, $archivedState) {
        $query = $this->getEntityManager()->createQuery("
            SELECT p FROM App\Entity\Pursuit p
            WHERE p.site = :site AND p.state != :archived
            ORDER BY p.dateStart DESC")
            ->setParameter('site', $site)
            ->setParameter('archived', $archivedState);
        return $query->getResult();
    }
}
