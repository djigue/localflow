<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<User>
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    // Tu peux ajouter ici d'autres requêtes personnalisées si besoin, par exemple :
    //
    // public function findBySomething($value): array
    // {
    //     return $this->createQueryBuilder('u')
    //         ->andWhere('u.someField = :val')
    //         ->setParameter('val', $value)
    //         ->getQuery()
    //         ->getResult();
    // }
}
