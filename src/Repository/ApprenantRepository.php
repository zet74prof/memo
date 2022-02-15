<?php

namespace App\Repository;

use App\Entity\Apprenant;
use App\Entity\Site;
use App\Entity\Territoire;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Apprenant|null find($id, $lockMode = null, $lockVersion = null)
 * @method Apprenant|null findOneBy(array $criteria, array $orderBy = null)
 * @method Apprenant[]    findAll()
 * @method Apprenant[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ApprenantRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Apprenant::class);
    }

    /**
     * @return Apprenant[] Returns an array of Apprenant objects
     */
    public function findAllCurrentInValidation()
    {
        $apprenants = $this->findAll();
        $apprenantsInValidation = [];
        foreach ($apprenants as $apprenant)
        {
            if ($apprenant->getLastState() == 1)
            {
                $apprenantsInValidation[] = $apprenant;
            }
        }
        return $apprenantsInValidation;
    }

    /**
     * @return Apprenant[] Returns an array of Apprenant objects
     */
    public function findAllCurrentActive()
    {
        $apprenants = $this->findAll();
        $apprenantsActive = [];
        foreach ($apprenants as $apprenant)
        {
            if ($apprenant->getLastState() == 2)
            {
                $apprenantsActive[] = $apprenant;
            }
        }
        return $apprenantsActive;
    }

    /**
     * @return Apprenant[] Returns an array of Apprenant objects
     */
    public function findAllCurrentInactive()
    {
        $apprenants = $this->findAll();
        $apprenantsInactive = [];
        foreach ($apprenants as $apprenant)
        {
            if ($apprenant->getLastState() == 3)
            {
                $apprenantsInactive[] = $apprenant;
            }
        }
        return $apprenantsInactive;
    }

    /**
     * @return Apprenant[] Returns an array of Apprenant objects
     */
    public function findAllCurrentInPause()
    {
        $apprenants = $this->findAll();
        $apprenantsInPause = [];
        foreach ($apprenants as $apprenant)
        {
            if ($apprenant->getLastState() == 4)
            {
                $apprenantsInPause[] = $apprenant;
            }
        }
        return $apprenantsInPause;
    }

    /**
    * @return Apprenant[] Returns an array of Apprenant objects
    */
    public function findByFilter(?Territoire $territoire, ?Site $site, \DateTime $dateDeb, \DateTime $dateFin)
    {
        $qb = $this->createQueryBuilder('a')
            ->innerJoin('a.siteHisto','siteHisto')
            ->innerJoin('siteHisto.sites', 'site')
            ->innerJoin('site.territoire','t')
            ->innerJoin('a.stateHisto', 'state');
        if ($territoire != null)
        {
            $qb->where('t = :territoire')
                ->setParameter('territoire', $territoire);
        }
        if ($site != null)
        {
            $qb->andWhere('site = :siteparam')
                ->setParameter('siteparam', $site);
        }
        $qb->andWhere('siteHisto.date BETWEEN :dateDeb AND :dateFin')
            ->andWhere('state.date BETWEEN :dateDeb AND :dateFin')
            ->andWhere('state.state = 2')
            ->setParameter('dateDeb', $dateDeb)
            ->setParameter('dateFin', $dateFin);

        $list = $qb
            ->getQuery()
            ->getResult();

        return $list;
    }

    /**
     * @return Apprenant[] Returns an array of Apprenant objects
     */
    public function findBirthdayNextMonth()
    {
        $list = $this->findAllCurrentActive();
        $listBirthday = [];
        foreach ($list as $apprenant)
        {
            $today = new \DateTime('now');
            $nextMonth = $today->format('n') + 1;
            if (intval($apprenant->getBirthDate()->format('n')) == $nextMonth)
            {
                $listBirthday[] = $apprenant;
            }
        }

        return $listBirthday;
    }


    /*
    public function findOneBySomeField($value): ?Apprenant
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
