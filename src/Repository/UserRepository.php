<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

/**
 * @extends ServiceEntityRepository<User>
 *
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function add(User $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(User $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setPassword($newHashedPassword);

        $this->add($user, true);
    }

    public function getCountUser()
    {
        return $this->createQueryBuilder('u')
            ->select('COUNT(u.id) as userCount')
            ->andWhere('u.roles = :val')
            ->setParameter('val', '["ROLE_USER"]')
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function getCountUserToday()
    {

        $date = new \DateTimeImmutable();
        $date = $date->modify('-1 day');

        return $this->createQueryBuilder('u')
            ->select('COUNT(u.id) as userCount')
            ->andWhere('u.createdAt BETWEEN :date AND :now')
            ->setParameter('now', new \DateTimeImmutable())
            ->setParameter('date', $date)
            ->andWhere('u.roles = :val')
            ->setParameter('val', '["ROLE_USER"]')
            ->getQuery()
            ->getSingleScalarResult();
    }

    //methode qui recupere les utilisateurs qui ont le role admin ou manager
    public function findByRoleAdminManager()
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.roles = :admin')
            ->setParameter('admin', '["ROLE_ADMIN"]')
            ->orWhere('u.roles = :manager')
            ->setParameter('manager', '["ROLE_MANAGER"]')
            ->getQuery()
            ->getResult();
    }

    

    //    /**
    //     * @return User[] Returns an array of User objects
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


}
