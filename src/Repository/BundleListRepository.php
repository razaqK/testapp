<?php

namespace App\Repository;

use App\Entity\BundleList;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method BundleList|null find($id, $lockMode = null, $lockVersion = null)
 * @method BundleList|null findOneBy(array $criteria, array $orderBy = null)
 * @method BundleList[]    findAll()
 * @method BundleList[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BundleListRepository extends BaseRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, BundleList::class);
    }

    // /**
    //  * @return BundleList[] Returns an array of BundleList objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?BundleList
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
