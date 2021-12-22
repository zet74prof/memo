<?php

namespace App\Repository;

use App\Entity\NivFormHisto;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method NivFormHisto|null find($id, $lockMode = null, $lockVersion = null)
 * @method NivFormHisto|null findOneBy(array $criteria, array $orderBy = null)
 * @method NivFormHisto[]    findAll()
 * @method NivFormHisto[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NivFormHistoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NivFormHisto::class);
    }

    // /**
    //  * @return NivFormHisto[] Returns an array of NivFormHisto objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('n.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?NivFormHisto
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
