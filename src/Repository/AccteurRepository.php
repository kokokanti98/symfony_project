<?php

namespace App\Repository;

use App\Entity\Accteur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Accteur|null find($id, $lockMode = null, $lockVersion = null)
 * @method Accteur|null findOneBy(array $criteria, array $orderBy = null)
 * @method Accteur[]    findAll()
 * @method Accteur[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AccteurRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Accteur::class);
    }

    // /**
    //  * @return Accteur[] Returns an array of Accteur objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Accteur
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
