<?php


namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Bouteilles;
use Doctrine\ORM\QueryBuilder;

class BouteillesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Bouteilles::class);
    }

    public function queryByUserCaves(User $user): QueryBuilder
    {
        return $this->createQueryBuilder('b')
            ->innerJoin('b.caves', 'c')
            ->andWhere('c.user = :user')
            ->setParameter('user', $user)
            ->orderBy('b.name', 'ASC')
        ;
    }

    public function findByUserCaves(User $user): array
    {
        return $this->queryByUserCaves($user)
            ->getQuery()
            ->getResult();
    }
}