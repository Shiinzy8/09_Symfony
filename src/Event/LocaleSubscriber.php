<?php
/**
 * Created by PhpStorm.
 * User: arkhyliuk
 * Date: 14.11.18
 * Time: 17:03
 */

namespace App\Event;


use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * Class LocaleSubscriber
 * @package App\Event
 */
class LocaleSubscriber implements EventSubscriberInterface
{

    /**
     * @var string
     */
    public $defaultLocale;

    /**
     * LocaleSubscriber constructor.
     * @param string $defaultLocale
     */
    public function __construct($defaultLocale = 'en')
    {
        $this->defaultLocale = $defaultLocale;
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
        // подписываемся на событие
        return [
            KernelEvents::REQUEST => [
                'onKernelRequest',
                20
            ],
        ];
    }

    /**
     * @param GetResponseEvent $event
     */
    public function onKernelRequest(GetResponseEvent $event) {
        // во всех ивентах есть обьект Request
        $request = $event->getRequest();

        // если была предыдущая сессия то прекращаем работу
        if (!$request->hasPreviousSession()) {
            return;
        }

        // проверяем сохранена ли локаль для пользователя
        if ($locale = $request->attributes->get('_locale')) {
            // если установлена то записываем ее в сессию
            $request->getSession()->set('_locale', $locale);
        } else {
            // если нет то устанавливает аттрибут локали с помощью занчения сессии
            $request->setLocale($request->getSession()->get('_locale', $this->defaultLocale));
        }
    }
}