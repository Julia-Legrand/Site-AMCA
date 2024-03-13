<?php

namespace App\Repository;

use App\Entity\PreviousTrips;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PreviousTrips>
 *
 * @method PreviousTrips|null find($id, $lockMode = null, $lockVersion = null)
 * @method PreviousTrips|null findOneBy(array $criteria, array $orderBy = null)
 * @method PreviousTrips[]    findAll()
 * @method PreviousTrips[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PreviousTripsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PreviousTrips::class);
    }

//    /**
//     * @return PreviousTrips[] Returns an array of PreviousTrips objects
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

//    public function findOneBySomeField($value): ?PreviousTrips
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
