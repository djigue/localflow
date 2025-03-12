<?php

namespace App\Repository;

use App\Entity\PaniersPromotions;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PaniersPromotions>
 */
class PaniersPromotionsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PaniersPromotions::class);
    }

    public function getPanierPromotion($userId)
{
    return $this->createQueryBuilder('pp')
        ->select('p.id, p.nom, p.nouveau_prix, pp.quantite, u.id AS user_id, i.url AS image')
        ->join('pp.promotion', 'p')  // Jointure avec Produits
        ->join('pp.utilisateur', 'u') // Jointure avec User
        ->leftJoin('p.imagesPromotions', 'i', 'WITH', 'i.id = (SELECT MIN(i2.id) FROM App\Entity\ImagesPromotions i2 WHERE i2.promotion = p.id)')
        ->where('u.id = :userId')  // Filtrer par l'utilisateur
        ->setParameter('userId', $userId)  // Sécuriser la requête
        ->getQuery()
        ->getResult();
}

    //    /**
    //     * @return PaniersPromotions[] Returns an array of PaniersPromotions objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('p.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?PaniersPromotions
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
