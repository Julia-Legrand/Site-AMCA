<?php

namespace App\Repository;

use App\Entity\MemoryDuty;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<MemoryDuty>
 *
 * @method MemoryDuty|null find($id, $lockMode = null, $lockVersion = null)
 * @method MemoryDuty|null findOneBy(array $criteria, array $orderBy = null)
 * @method MemoryDuty[]    findAll()
 * @method MemoryDuty[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MemoryDutyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MemoryDuty::class);
    }

//    /**
//     * @return MemoryDuty[] Returns an array of MemoryDuty objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('m.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?MemoryDuty
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
