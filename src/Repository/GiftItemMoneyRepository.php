<?php

namespace App\Repository;

use App\Entity\GiftItemMoney;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method GiftItemMoney|null find($id, $lockMode = null, $lockVersion = null)
 * @method GiftItemMoney|null findOneBy(array $criteria, array $orderBy = null)
 * @method GiftItemMoney[]    findAll()
 * @method GiftItemMoney[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GiftItemMoneyRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, GiftItemMoney::class);
    }

    // /**
    //  * @return GiftItemMoney[] Returns an array of GiftItemMoney objects
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
    public function findOneBySomeField($value): ?GiftItemMoney
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
