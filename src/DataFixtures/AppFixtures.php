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
        // сначала надо вызывать создание пользователя потому что посты используют
        // ссылку на пользователя, если его не будет посты не создадутся
        $this->loadUser($manager);
        $this->loadMicroPost($manager);
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

            // по скольку мы добавили связь между постами и пользователем то в фикстурах ее тоже надо создавать
            // здесь мы создали ссылку на пользователя которого указали когда создавали пользователя
            $microPost->setUser($this->getReference('andrii'));
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

        // создаем ссылку, созданный пользователь привязывается к ссылке andrii
        $this->addReference('andrii', $user);

        $manager->persist($user);
        $manager->flush();
    }
}