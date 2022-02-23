<?php

namespace App\Repository;

use App\Entity\CourseOfLife;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CourseOfLife|null find($id, $lockMode = null, $lockVersion = null)
 * @method CourseOfLife|null findOneBy(array $criteria, array $orderBy = null)
 * @method CourseOfLife[]    findAll()
 * @method CourseOfLife[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CourseOfLifeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CourseOfLife::class);
    }

    // /**
    //  * @return CourseOfLife[] Returns an array of CourseOfLife objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CourseOfLife
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
