<?php

namespace App\Repository;

use App\Entity\PaniersProduits;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PaniersProduits>
 */
class PaniersProduitsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PaniersProduits::class);
    }

    public function getPanierProduit($userId)
{
    return $this->createQueryBuilder('pp')
        ->select('p.id, p.nom, p.prix, p.format_prix, pp.quantite, u.id AS user_id, i.url AS image')
        ->join('pp.produit', 'p')  // Jointure avec Produits
        ->join('pp.utilisateur', 'u') // Jointure avec User
        ->leftJoin('p.imagesProduits', 'i', 'WITH', 'i.id = (SELECT MIN(i2.id) FROM App\Entity\ImagesProduits i2 WHERE i2.produit = p.id)')
        ->where('u.id = :userId')  // Filtrer par l'utilisateur
        ->setParameter('userId', $userId)  // Sécuriser la requête
        ->getQuery()
        ->getResult();
}


    //    /**
    //     * @return PaniersProduits[] Returns an array of PaniersProduits objects
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

    //    public function findOneBySomeField($value): ?PaniersProduits
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
