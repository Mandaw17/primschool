<?php

namespace App\Repository;

use App\Entity\Testeur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Testeur|null find($id, $lockMode = null, $lockVersion = null)
 * @method Testeur|null findOneBy(array $criteria, array $orderBy = null)
 * @method Testeur[]    findAll()
 * @method Testeur[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TesteurRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Testeur::class);
    }

    // /**
    //  * @return Testeur[] Returns an array of Testeur objects
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
    public function findOneBySomeField($value): ?Testeur
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
