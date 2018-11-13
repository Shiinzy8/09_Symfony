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
use phpDocumentor\Reflection\Types\Self_;
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

    private const USERS = [
        [
            'userName' => 'john_doe',
            'email' => 'john_doe@doe.com',
            'password' => 'john123',
            'fullName' => 'John Doe',
            'roles' => [User::ROLE_USER],
        ],
        [
            'userName' => 'rob_smith',
            'email' => 'rob_smith@smith.com',
            'password' => 'rob12345',
            'fullName' => 'Rob Smith',
            'roles' => [User::ROLE_USER],
        ],
        [
            'userName' => 'marry_gold',
            'email' => 'marry_gold@gold.com',
            'password' => 'marry12345',
            'fullName' => 'Marry Gold',
            'roles' => [User::ROLE_USER],
        ],
        [
            'userName' => 'super_admin',
            'email' => 'super_admin@gold.com',
            'password' => 'super12345',
            'fullName' => 'Super Admin',
            'roles' => [User::ROLE_ADMIN],
        ],
    ];

    private const POST_TEXT = [
        'Hello, how are you?',
        'It\'s nice sunny weather today',
        'I need to buy some ice cream!',
        'I wanna buy a new car',
        'There\'s a problem with my phone',
        'I need to go to the doctor',
        'What are you up to today?',
        'Did you watch the game yesterday?',
        'How was your day?'
    ];

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
        for ($i = 0; $i < 30; $i++) {
            $microPost = new MicroPost();
            $microPost->setText(self::POST_TEXT[rand(0, count(self::POST_TEXT) - 1)]);

            $dateTime = new \DateTime();
            $dateTime->modify('-' . rand(0, 10) . ' day' );
            $microPost->setTime($dateTime);

            // по скольку мы добавили связь между постами и пользователем то в фикстурах ее тоже надо создавать
            // здесь мы создали ссылку на пользователя которого указали когда создавали пользователя
            $microPost->setUser($this->getReference(
                self::USERS[rand(0, count(self::USERS) - 1)]['userName'])
            );
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
        foreach (self::USERS as $userData) {
            $user = new User();
            $user->setUserName($userData['userName']);
            $user->setFullName($userData['fullName']);
            $user->setEmail($userData['email']);
            $user->setPassword($this->passwordEncoder->encodePassword($user, $userData['password']));
            $user->setRoles($userData['roles']);
            $user->setEnabled(true);

            // создаем ссылку, созданный пользователь привязывается к ссылке andrii
            $this->addReference($userData['userName'], $user);

            $manager->persist($user);
        }

        $manager->flush();
    }
}