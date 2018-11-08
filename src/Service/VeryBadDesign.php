<?php
/**
 * Created by PhpStorm.
 * User: arkhyliuk
 * Date: 10.10.18
 * Time: 17:31
 */

namespace App\Service;


use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class VeryBadDesign implements ContainerAwareInterface
{

    /**
     * @required
     * @param ContainerInterface|null $container
     */
    public function setContainer(ContainerInterface $container = null)
    {
        // $container->get(Greeting::class);
        // после того как мы в services.yaml создали alias для app.greeting и дали ему свойство public:true
        // мы можем заменить эту записть на такуюжу но с использованием alias
//        $container->get('app.greeting');
    }
}