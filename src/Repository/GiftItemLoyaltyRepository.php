<?php

namespace App\Repository;

use App\Entity\GiftItemLoyalty;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method GiftItemLoyalty|null find($id, $lockMode = null, $lockVersion = null)
 * @method GiftItemLoyalty|null findOneBy(array $criteria, array $orderBy = null)
 * @method GiftItemLoyalty[]    findAll()
 * @method GiftItemLoyalty[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GiftItemLoyaltyRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, GiftItemLoyalty::class);
    }

    // /**
    //  * @return GiftItemLoyalty[] Returns an array of GiftItemLoyalty objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('g.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?GiftItemLoyalty
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
