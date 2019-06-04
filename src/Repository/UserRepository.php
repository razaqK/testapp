<?php

namespace App\Repository;

use App\Entity\OrderItem;
use App\Entity\Product;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends BaseRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, User::class);
    }

    // /**
    //  * @return User[] Returns an array of User objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?User
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function findAllOrders(int $page, int $limit, int $userId)
    {
        $query = $this->createQueryBuilder('u')
            ->select(['u'])
            ->innerJoin('u.orders', 'o')
            ->innerJoin('o.items', 'oi')
            ->innerJoin(Product::class, 'p', Join::WITH, 'p.id = oi.product_id')
            ->andWhere('u.id = :user_id')
            ->setParameter('user_id', $userId);
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
}
