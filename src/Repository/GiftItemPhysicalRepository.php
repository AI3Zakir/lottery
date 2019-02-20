<?php

namespace App\Repository;

use App\Entity\GiftItemPhysical;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method GiftItemPhysical|null find($id, $lockMode = null, $lockVersion = null)
 * @method GiftItemPhysical|null findOneBy(array $criteria, array $orderBy = null)
 * @method GiftItemPhysical[]    findAll()
 * @method GiftItemPhysical[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GiftItemPhysicalRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, GiftItemPhysical::class);
    }

    // /**
    //  * @return GiftItemPhysical[] Returns an array of GiftItemPhysical objects
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
    public function findOneBySomeField($value): ?GiftItemPhysical
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
