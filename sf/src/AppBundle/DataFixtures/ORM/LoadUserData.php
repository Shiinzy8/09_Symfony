<?php
// src/AppBundle/DataFixtures/ORM/LoadUserData.php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

// for using $this->container->get
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

use AppBundle\Entity\User;

class LoadUserData implements FixtureInterface, ContainerAwareInterface
{
    /**
     * @param ContainerInterface
     */
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
//        $user = new User();
//        $passwordPlain = 'admin';
//
//        $encoder = $this->container->get('security.password_encoder');
//
//        $passwordEncoded = $encoder->encodePassword($user, $passwordPlain);
//
//        $user->setLogin('admin');
//        $user->setEmail('admin@item.com');
//        $user->setPassword($passwordEncoded);
//        $user->setRoles(['ROLE_ADMIN','ROLE_SOMETHING']);
//
//        $manager->persist($user);
//        $manager->flush();

        $user = new User();
        $passwordPlain = 'manager';

        $encoder = $this->container->get('security.password_encoder');

        $passwordEncoded = $encoder->encodePassword($user, $passwordPlain);

        $user->setLogin('manager');
        $user->setEmail('manager@item.com');
        $user->setPassword($passwordEncoded);
        $user->setRoles(['ROLE_SOMETHING']);

        $manager->persist($user);
        $manager->flush();
    }
}