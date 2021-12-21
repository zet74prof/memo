<?php

namespace App\Repository;

use App\Entity\StateHisto;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method StateHisto|null find($id, $lockMode = null, $lockVersion = null)
 * @method StateHisto|null findOneBy(array $criteria, array $orderBy = null)
 * @method StateHisto[]    findAll()
 * @method StateHisto[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StateHistoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StateHisto::class);
    }

    // /**
    //  * @return StateHisto[] Returns an array of StateHisto objects
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
    public function findOneBySomeField($value): ?StateHisto
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
