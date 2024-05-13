<?php

namespace App\Repository;

use App\Entity\PressReviews;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PressReview>
 *
 * @method PressReview|null find($id, $lockMode = null, $lockVersion = null)
 * @method PressReview|null findOneBy(array $criteria, array $orderBy = null)
 * @method PressReview[]    findAll()
 * @method PressReview[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PressReviewsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PressReviews::class);
    }

    //    /**
    //     * @return PressReview[] Returns an array of PressReview objects
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

    //    public function findOneBySomeField($value): ?PressReview
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
