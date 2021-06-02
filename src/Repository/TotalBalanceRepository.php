<?php

namespace User\Balance\Repository;

use User\Balance\Entity\TotalBalance;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TotalBalance|null find($id, $lockMode = null, $lockVersion = null)
 * @method TotalBalance|null findOneBy(array $criteria, array $orderBy = null)
 * @method TotalBalance[]    findAll()
 * @method TotalBalance[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TotalBalanceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TotalBalance::class);
    }

    // /**
    //  * @return TotalBalance[] Returns an array of TotalBalance objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TotalBalance
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
