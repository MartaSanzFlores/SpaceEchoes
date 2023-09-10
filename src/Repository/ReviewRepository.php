<?php

namespace App\Repository;

use App\Entity\Review;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Review>
 *
 * @method Review|null find($id, $lockMode = null, $lockVersion = null)
 * @method Review|null findOneBy(array $criteria, array $orderBy = null)
 * @method Review[]    findAll()
 * @method Review[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReviewRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Review::class);
    }

    public function add(Review $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Review $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }


    /**
     * Get reported review and report count
     * @return array
     */
    public function getReviewsReported()
    {   
        //requette pour lister les commentaires signalés et le nombre de signalement
        $reviewsReported = $this->createQueryBuilder('r')
            ->innerJoin('r.UsersReports', 'u')
            ->select('r.id', 'r.content', 'COUNT(u) as reportedCount')
            ->groupBy('r.id')
            ->having('reportedCount > 0')
            ->getQuery()
            ->getResult();
        return $reviewsReported;
    }


   /**
     * Get reports count
     * @return int
     */
    public function countReviewsReported()
    {   
        //requette pour calculer le nombre de signalement .
        $countReviewsReported = $this->createQueryBuilder('r')
            ->innerJoin('r.UsersReports', 'u')
            ->select('COUNT(r) as reviewsReportedCount')
            ->getQuery()
            ->getSingleScalarResult();
        return $countReviewsReported;
    }







    //    /**
    //     * @return Review[] Returns an array of Review objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('r.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Review
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
