<?php

namespace App\Repository;

use App\Entity\RessourceHisto;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method RessourceHisto|null find($id, $lockMode = null, $lockVersion = null)
 * @method RessourceHisto|null findOneBy(array $criteria, array $orderBy = null)
 * @method RessourceHisto[]    findAll()
 * @method RessourceHisto[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RessourceHistoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RessourceHisto::class);
    }

    // /**
    //  * @return RessourceHisto[] Returns an array of RessourceHisto objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?RessourceHisto
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
