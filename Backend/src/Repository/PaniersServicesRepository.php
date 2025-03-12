<?php

namespace App\Repository;

use App\Entity\PaniersServices;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PaniersServices>
 */
class PaniersServicesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PaniersServices::class);
    }

    public function getPanierService($userId)
    {
        return $this->createQueryBuilder('ps')
            ->select('s.id, s.nom, s.prix, ps.quantite, u.id AS user_id, i.url AS image')
            ->join('ps.service', 's')  // Jointure avec Produits
            ->join('ps.utilisateur', 'u') // Jointure avec User
            ->leftJoin('s.imagesServices', 'i', 'WITH', 'i.id = (SELECT MIN(i2.id) FROM App\Entity\ImagesServices i2 WHERE i2.service = s.id)')
            ->where('u.id = :userId')  // Filtrer par l'utilisateur
            ->setParameter('userId', $userId)  // Sécuriser la requête
            ->getQuery()
            ->getResult();
    }

    //    /**
    //     * @return PaniersServices[] Returns an array of PaniersServices objects
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

    //    public function findOneBySomeField($value): ?PaniersServices
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
