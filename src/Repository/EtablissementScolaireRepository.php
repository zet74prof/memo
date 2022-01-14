<?php

namespace App\Repository;

use App\Entity\EtablissementScolaire;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method EtablissementScolaire|null find($id, $lockMode = null, $lockVersion = null)
 * @method EtablissementScolaire|null findOneBy(array $criteria, array $orderBy = null)
 * @method EtablissementScolaire[]    findAll()
 * @method EtablissementScolaire[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EtablissementScolaireRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EtablissementScolaire::class);
    }

    // /**
    //  * @return EtablissementScolaire[] Returns an array of EtablissementScolaire objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?EtablissementScolaire
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
