<?php

namespace App\Repository;

use App\Entity\Notification;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Notification|null find($id, $lockMode = null, $lockVersion = null)
 * @method Notification|null findOneBy(array $criteria, array $orderBy = null)
 * @method Notification[]    findAll()
 * @method Notification[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NotificationRepository extends ServiceEntityRepository
{
    /**
     * NotificationRepository constructor.
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Notification::class);
    }

    /**
     * запрос для подсчета количества нотификаций которые не видел пользовательй
     * @param User $user
     *
     * @return int
     *
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findUnseenByUser(User $user) :int {
        $sql = $this->createQueryBuilder('n');

        return $sql->select('count(n)')
            ->where('n.user = :user')
            ->andWhere('n.seen = FALSE')
            ->setParameter('user', $user)
            ->getQuery()
            ->getSingleScalarResult();
    }

    /**
     * Отмечает все нотификации пользователя как просмотренные
     * @param User $user
     */
    public function markAsReadByUser(User $user)
    {
        $sql = $this->createQueryBuilder('n');

        $sql->update('App\Entity\Notification')
            ->set('n.seen', true)
            ->where('n.user = :user')
            ->setParameter('user', $user)
            ->getQuery()
            ->execute();
    }

//    /**
//     * @return Notification[] Returns an array of Notification objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('n.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Notification
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
