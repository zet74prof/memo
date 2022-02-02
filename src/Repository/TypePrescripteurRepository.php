<?php

namespace App\Repository;

use App\Entity\TypePrescripteur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TypePrescripteur|null find($id, $lockMode = null, $lockVersion = null)
 * @method TypePrescripteur|null findOneBy(array $criteria, array $orderBy = null)
 * @method TypePrescripteur[]    findAll()
 * @method TypePrescripteur[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TypePrescripteurRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TypePrescripteur::class);
    }

    // /**
    //  * @return TypePrescripteur[] Returns an array of TypePrescripteur objects
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
    public function findOneBySomeField($value): ?TypePrescripteur
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
