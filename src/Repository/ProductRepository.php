<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends BaseRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Product::class);
    }

    // /**
    //  * @return Product[] Returns an array of Product objects
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
    public function findOneBySomeField($value): ?Product
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    /**
     * @param int $page
     * @param int $limit
     * @return mixed
     */
    public function findAllRecords(int $page, int $limit)
    {
        $query = $this->createQueryBuilder('p')
            ->select(['p.id', 'p.name', 'p.amount', 'p.currency', 'p.discounted_amount', 'p.status']);
        if (!empty($page) && !empty($limit)) {
            $offset = $page <= 0 ? 0 : ($page - 1) * $limit;
            $query->setFirstResult($offset);
            $query->setMaxResults($limit);
        }
        if (!empty($limit) && empty($page)) {
            $query->setMaxResults($limit);
        }

        return $query->getQuery()
            ->getResult();
    }

    public function getProductsByIds(array $ids)
    {
        $query = $this->createQueryBuilder('p')
            ->select(['p.amount', 'p.discounted_amount', 'p.id']);
        $query->add('where', $query->expr()->in('p.id', $ids));
        return $query->getQuery()
            ->getResult();
    }
}
