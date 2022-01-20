<?php

namespace App\Repository;

use App\Entity\StatusHisto;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method StatusHisto|null find($id, $lockMode = null, $lockVersion = null)
 * @method StatusHisto|null findOneBy(array $criteria, array $orderBy = null)
 * @method StatusHisto[]    findAll()
 * @method StatusHisto[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StatusHistoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StatusHisto::class);
    }

    // /**
    //  * @return StatusHisto[] Returns an array of StatusHisto objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?StatusHisto
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
