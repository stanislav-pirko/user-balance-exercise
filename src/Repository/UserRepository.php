<?php

namespace User\Balance\Repository;

use Doctrine\ORM\Query;
use User\Balance\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * Fetch all users from database and return array.
     *
     * @return mixed[]
     */
    public function getUsers(): array
    {
        return $this->createQueryBuilder('u')
            ->select()
            ->getQuery()
            ->getResult(Query::HYDRATE_ARRAY);
    }

    /**
     * Find and return user by user id and return in array.
     *
     * @param int $userId
     *
     * @return mixed[]
     */
    public function getUser(int $userId): array
    {
        return $this->createQueryBuilder('u')
            ->select()
            ->andWhere('u.id = :val')
            ->setParameter('val', $userId)
            ->getQuery()
            ->getResult(Query::HYDRATE_ARRAY);
    }

    // /**
    //  * @return User[] Returns an array of User objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*public function getUser(int $userId): ?User
    {
        return $this->createQueryBuilder('u')
            ->select('balance')
            ->andWhere('u.id = :val')
            ->setParameter('val', $userId)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }*/
}
