<?php


namespace App\Repository;


use App\Entity\BaseEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

abstract class BaseRepository extends ServiceEntityRepository implements IRepository
{
    public function __construct(RegistryInterface $registry, string $entity)
    {
        parent::__construct($registry, $entity);
    }

    /**
     * @param $filter
     * @param $bind
     * @param string $sort
     * @return mixed
     */
    public function findByFields(string $filter, array $bind = [], $sort = 'ASC')
    {
        $builder = $this->createQueryBuilder('b')
            ->andWhere($filter);

        if (!empty($bind)) {
            $builder->setParameters($bind);
        }

        return $builder->orderBy('b.id', $sort)
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
    }


    /**
     * @param $filter
     * @param $bind
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findOneByFields(string $filter, array $bind = [])
    {
        $builder = $this->createQueryBuilder('b')
            ->andWhere($filter);
        if (!empty($bind)) {
            $builder->setParameters($bind);
        }
        return $builder->getQuery()
            ->getOneOrNullResult();
    }
}