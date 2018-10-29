<?php
/**
 * Created by PhpStorm.
 * User: arkhyliuk
 * Date: 24.10.18
 * Time: 18:18
 */

namespace App\DataFixtures;


use App\Entity\MicroPost;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class AppFixtures
 * @package App\DataFixtures
 */
class AppFixtures extends Fixture
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    /**
     * AppFixtures constructor.
     * @param UserPasswordEncoderInterface $passwordEncoder
     */
    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {

        $this->passwordEncoder = $passwordEncoder;
    }


    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $this->loadMicroPost($manager);
        $this->loadUser($manager);
    }

    /**
     * @param ObjectManager $manager
     */
    private function loadMicroPost(ObjectManager $manager)
    {
        for ($i = 0; $i < 10; $i++) {
            $microPost = new MicroPost();
            $microPost->setText('Some random text ' . rand(0, 100));
            $microPost->setTime(new \DateTime('2008-03-15'));
            $manager->persist($microPost);
        }

        // сохранит то что было передано в persist
        // что б запустить фикстуры надо вызвать команду php bin/console doctrine:fixtures:load
        // что б id записей начиналось с 0 надо добавлять опцию --purge-with-truncate
        $manager->flush();
    }

    /**
     * @param ObjectManager $manager
     */
    private function loadUser(ObjectManager $manager)
    {
        $user = new User();
        $user->setUserName('john_doe');
        $user->setFullName('John Doe');
        $user->setEmail('john_doe@gmail.com');
        $user->setPassword($this->passwordEncoder->encodePassword($user, 'john123'));

        $manager->persist($user);
        $manager->flush();
    }
}