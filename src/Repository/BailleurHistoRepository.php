<?php

namespace App\Repository;

use App\Entity\BailleurHisto;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method BailleurHisto|null find($id, $lockMode = null, $lockVersion = null)
 * @method BailleurHisto|null findOneBy(array $criteria, array $orderBy = null)
 * @method BailleurHisto[]    findAll()
 * @method BailleurHisto[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BailleurHistoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BailleurHisto::class);
    }

    // /**
    //  * @return BailleurHisto[] Returns an array of BailleurHisto objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?BailleurHisto
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
