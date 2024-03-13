<?php

namespace App\Repository;

use App\Entity\TripPictures;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TripPictures>
 *
 * @method TripPictures|null find($id, $lockMode = null, $lockVersion = null)
 * @method TripPictures|null findOneBy(array $criteria, array $orderBy = null)
 * @method TripPictures[]    findAll()
 * @method TripPictures[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TripPicturesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TripPictures::class);
    }

//    /**
//     * @return TripPictures[] Returns an array of TripPictures objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('t.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?TripPictures
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
