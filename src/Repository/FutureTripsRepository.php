<?php

namespace App\Repository;

use App\Entity\FutureTrips;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<FutureTrips>
 *
 * @method FutureTrips|null find($id, $lockMode = null, $lockVersion = null)
 * @method FutureTrips|null findOneBy(array $criteria, array $orderBy = null)
 * @method FutureTrips[]    findAll()
 * @method FutureTrips[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FutureTripsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FutureTrips::class);
    }

//    /**
//     * @return FutureTrips[] Returns an array of FutureTrips objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('f.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?FutureTrips
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
