<?php
/**
 * Created by PhpStorm.
 * User: arkhyliuk
 * Date: 12.11.18
 * Time: 16:49
 */

namespace App\Event;


use App\Mailer\Mailer;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class UserSubscriber
 * @package App\Event
 */
class UserSubscriber implements EventSubscriberInterface
{
    // что б проверить что сервис создалься настроился
    // php bin/console debug:container 'App\Event\UserSubscriber'

//    /**
//     * @var \Swift_Mailer
//     */
//    private $mailer;
//    /**
//     * @var \Twig_Environment
//     */
//    private $twig;
//
//    /**
//     * UserSubscriber constructor.
//     * @param \Swift_Mailer $mailer
//     * @param \Twig_Environment $twig
//     */
//    public function __construct(\Swift_Mailer $mailer, \Twig_Environment $twig)
//    {
//        $this->mailer = $mailer;
//        $this->twig = $twig;
//    }

    /**
     * @var Mailer
     */
    private $mailer;

// мы переписали контсруктор отдава Мейлеру все полномочия по отправке писем
    /**
     * UserSubscriber constructor.
     * @param Mailer $mailer
     */
    public function __construct(Mailer $mailer)
    {

        $this->mailer = $mailer;
    }

    /**
     * Returns an array of event names this subscriber wants to listen to.
     *
     * The array keys are event names and the value can be:
     *
     *  * The method name to call (priority defaults to 0)
     *  * An array composed of the method name to call and the priority
     *  * An array of arrays composed of the method names to call and respective
     *    priorities, or 0 if unset
     *
     * For instance:
     *
     *  * array('eventName' => 'methodName')
     *  * array('eventName' => array('methodName', $priority))
     *  * array('eventName' => array(array('methodName1', $priority), array('methodName2')))
     *
     * @return array The event names to listen to
     */
    public static function getSubscribedEvents()
    {
        // ключ это обработчик а значение метод этого обработчика который мы вызываем
        return [UserRegisterEvent::NAME => 'onUserRegister',];
    }

    /**
     * @param UserRegisterEvent $event
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function onUserRegister(UserRegisterEvent $event)
    {
        $this->mailer->sendConfirmationEmail($event->getRegisteredUser());
    }
}