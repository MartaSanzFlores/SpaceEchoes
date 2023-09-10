<?php

namespace App\Repository;

use App\Entity\Post;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Post>
 *
 * @method Post|null find($id, $lockMode = null, $lockVersion = null)
 * @method Post|null findOneBy(array $criteria, array $orderBy = null)
 * @method Post[]    findAll()
 * @method Post[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Post::class);
    }

    public function add(Post $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Post $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * Get recent posts
     * @return array
     */
    public function findRecentPosts()
    {  
        // requette pour récupérer les 3 articles les plus récents
        return $this->createQueryBuilder('m')
        ->orderBy('m.publishedAt', 'DESC')
        ->setMaxResults(4)
        ->getQuery()
        ->getResult();
    }

    /**
     * Get Published Posts
     * @return array
     */
    public function getPublishedPosts()
    {  
        // requette pour récupérer les 3 articles les plus récents
        return $this->createQueryBuilder('m')
        ->where('m.publishedAt <= :today')
        ->setParameter('today', new \DateTimeImmutable())
        ->getQuery()
        ->getResult();
    }
}
