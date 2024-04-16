<?php

namespace App\Repository;

use App\Entity\UserFlatHistory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<UserFlatHistory>
 *
 * @method UserFlatHistory|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserFlatHistory|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserFlatHistory[]    findAll()
 * @method UserFlatHistory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserFlatHistoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserFlatHistory::class);
    }

//    /**
//     * @return UserFlatHistory[] Returns an array of UserFlatHistory objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('u.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?UserFlatHistory
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
