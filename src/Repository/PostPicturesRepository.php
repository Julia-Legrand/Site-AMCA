<?php

namespace App\Repository;

use App\Entity\PostPictures;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PostPictures>
 *
 * @method PostPictures|null find($id, $lockMode = null, $lockVersion = null)
 * @method PostPictures|null findOneBy(array $criteria, array $orderBy = null)
 * @method PostPictures[]    findAll()
 * @method PostPictures[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostPicturesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PostPictures::class);
    }

//    /**
//     * @return PostPictures[] Returns an array of PostPictures objects
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

//    public function findOneBySomeField($value): ?PostPictures
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
