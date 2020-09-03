<?php

namespace App\Repository;

use App\Entity\ParentEleve;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ParentEleve|null find($id, $lockMode = null, $lockVersion = null)
 * @method ParentEleve|null findOneBy(array $criteria, array $orderBy = null)
 * @method ParentEleve[]    findAll()
 * @method ParentEleve[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ParentEleveRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ParentEleve::class);
    }

    // /**
    //  * @return ParentEleve[] Returns an array of ParentEleve objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ParentEleve
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
