<?php

namespace App\Repository;

use App\Entity\QPVHisto;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method QPVHisto|null find($id, $lockMode = null, $lockVersion = null)
 * @method QPVHisto|null findOneBy(array $criteria, array $orderBy = null)
 * @method QPVHisto[]    findAll()
 * @method QPVHisto[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QPVHistoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, QPVHisto::class);
    }

    // /**
    //  * @return QPVHisto[] Returns an array of QPVHisto objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('q')
            ->andWhere('q.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('q.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?QPVHisto
    {
        return $this->createQueryBuilder('q')
            ->andWhere('q.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
