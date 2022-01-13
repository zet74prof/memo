<?php

namespace App\Repository;

use App\Entity\TypeEnseignement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TypeEnseignement|null find($id, $lockMode = null, $lockVersion = null)
 * @method TypeEnseignement|null findOneBy(array $criteria, array $orderBy = null)
 * @method TypeEnseignement[]    findAll()
 * @method TypeEnseignement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TypeEnseignementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TypeEnseignement::class);
    }

    // /**
    //  * @return TypeEnseignement[] Returns an array of TypeEnseignement objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TypeEnseignement
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
