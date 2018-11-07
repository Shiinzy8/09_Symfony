<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    /**
     * UserRepository constructor.
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * @return mixed
     */
    public function findAllWithMoreThanFivePosts()
    {
        $query = $this->getAllWithMoreThanFivePostsQuery();
        return $query->getQuery()->getResult();
    }

    /**
     * @param User $user
     * @return mixed
     */
    public function findAllWithMoreThanFivePostsExceptUser(User $user)
    {
        $query = $this->getAllWithMoreThanFivePostsQuery();
        $query->andHaving('user != :user')->setParameter('user', $user);

        return $query->getQuery()->getResult();
    }

    /**
     * @return \Doctrine\ORM\QueryBuilder
     */
    private function getAllWithMoreThanFivePostsQuery() {
        $sql = $this->createQueryBuilder('user');

        return $sql->select('user')
            ->innerJoin('user.posts', 'userposts')
            ->groupBy('user')
            ->having('count(userposts) > 5');
    }

//    /**
//     * @return User[] Returns an array of User objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?User
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
