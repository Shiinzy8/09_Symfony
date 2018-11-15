<?php
/**
 * Created by PhpStorm.
 * User: arkhyliuk
 * Date: 09.11.18
 * Time: 17:28
 */

namespace App\EventListener;


use App\Entity\LikeNotification;
use App\Entity\MicroPost;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\OnFlushEventArgs;
use Doctrine\ORM\Events;
use Doctrine\ORM\PersistentCollection;

// что б listener заработал необходимо создать для него сервис
/**
 * Class LikeNotificationSubscriber
 * @package App\EventListener
 */
class LikeNotificationSubscriber implements EventSubscriber
{
    /**
     * Returns an array of events this subscriber wants to listen to.
     *
     * @return string[]
     */
    public function getSubscribedEvents()
    {
        return [
            Events::onFlush,
        ];
    }

    /**
     * @param OnFlushEventArgs $args
     * @throws \Doctrine\ORM\ORMException
     */
    public function onFlush(OnFlushEventArgs $args)
    {
        $entityManager = $args->getEntityManager();

        // именно union of work следит за всем что происходит с сущностями Entities через доктрину
        // то есть он знает когда добавляем запись, удаляем, изменяем структуру и т.д.
        $unionOfWork = $entityManager->getUnitOfWork();

        /**
         * @var PersistentCollection $collectionUpdate
         * это метод вернет все коллекции которые имплементируют Doctrine\Common\Collections\ArrayCollection;
         */
        foreach ($unionOfWork->getScheduledCollectionUpdates() as $collectionUpdate) {
            // проверяем если коллекция не пренадлежит нужному нам классу то пропускаем ее
            // нам надо получать нотификации о лайках постов
            if(!$collectionUpdate->getOwner() instanceof MicroPost) {
                continue;
            }

            // проверяем поле которое было модифицироно в сущности
            if('likeBy' !== $collectionUpdate->getMapping()['fieldName']) {
                continue;
            }

            // получаем записи которые были вставленны
            $insertDiff = $collectionUpdate->getInsertDiff();

            // если таких записей нет то ничего не возвращаем
            if (!count($insertDiff)) {
                return;
            }

            // поскольку мы уже отсекли коллекции которые не являются постами те что остались однозначно они
            /** @var MicroPost $microPost */
            $microPost = $collectionUpdate->getOwner();

            $notification = new LikeNotification();
            $notification->setUser($microPost->getUser());
            $notification->setMicroPost($microPost);
            $notification->setLikeBy(reset($insertDiff));

            $entityManager->persist($notification);
            $unionOfWork->computeChangeSet(
                $entityManager->getClassMetadata(LikeNotification::class),
                $notification
            );
        }
    }
}