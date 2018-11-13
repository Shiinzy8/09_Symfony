<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * эта строка надо потому что слово user зарезервировано в posgresql
 * @ORM\Table(name="`user`")
 *
 * можно задать как массив так одно поле и сообщение если уникальность была нарушена
 * @UniqueEntity(fields="email", message="This email is already used")
 * @UniqueEntity(fields="userName", message="This username is already used")
 */
class User implements UserInterface, \Serializable
{
    /**
     * роль пользователя
     */
    const ROLE_USER = 'ROLE_USER';
    /**
     * роль админа
     */
    const ROLE_ADMIN = 'ROLE_ADMIN';

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     *
     * @var int
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50, unique=true)
     * комментарий нужный что б пользователь не оставлял имя пустым
     * @Assert\NotBlank()
     * ограничиваем длину имени пользователя
     * @Assert\Length(min=5, max=50)
     *
     * @var string
     */
    private $userName;

    /**
     * @ORM\Column(type="string")
     *
     * @var string
     */
    private $password;

    /**
     * Не добавляя комментарий ORM поле не попадет в таблицу а будет просто параметром класса
     *
     * @Assert\NotBlank()
     * @Assert\Length(min=8, max=4096)
     *
     * @var
     */
    private $plainPassword;

    /**
     * @ORM\Column(type="string", length=254, unique=true)
     *
     * @Assert\NotBlank()
     * @Assert\Email()
     *
     * @var
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=50)
     *
     * @Assert\NotBlank()
     * @Assert\Length(min=4, max=50)
     *
     * @var
     */
    private $fullName;

    /**
     * у одного юзера много постов
     * @ORM\OneToMany(targetEntity="App\Entity\MicroPost", mappedBy="user")
     *
     * @var ArrayCollection
     */
    private $posts;

    /**
     * @ORM\Column(type="simple_array", options={"default":"ROLE_USER"})
     *
     * @var array
     */
    private $roles;


    /**
     * Для коллекций не надо создавать сеттеры
     *
     * @ORM\ManyToMany(targetEntity="App\Entity\User", mappedBy="following")
     *
     * @var ArrayCollection
     */
    private $followers;


    /**
     * Для коллекций не надо создавать сеттеры
     *
     * @ORM\ManyToMany(targetEntity="App\Entity\User", inversedBy="followers")
     * @ORM\JoinTable(name="following",
     *     joinColumns={
     *         @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     *     },
     *     inverseJoinColumns={
     *         @ORM\JoinColumn(name="following_user_id", referencedColumnName="id")
     *     }
     * )
     *
     * @var ArrayCollection
     */
    private $following;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\MicroPost", mappedBy="likeBy")
     *
     * @var ArrayCollection
     */
    private $postsLiked;

    /**
     * @ORM\Column(type="string", nullable=true, length=30)
     */
    private $confirmationToken;

    /**
     * @ORM\Column(type="boolean")
     */
    private $enabled;

    /**
     * Doctrine doesn't do construct method it's only for our use
     * User constructor.
     */
    public function __construct()
    {
        $this->posts = new ArrayCollection();
        $this->followers = new ArrayCollection();
        $this->following = new ArrayCollection();
        $this->postsLiked = new ArrayCollection();
        $this->roles = [User::ROLE_USER];
        $this->enabled = false;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Returns the roles granted to the user.
     *
     * <code>
     * public function getRoles()
     * {
     *     return array('ROLE_USER');
     * }
     * </code>
     *
     * Alternatively, the roles might be stored on a ``roles`` property,
     * and populated in any number of different ways when the user object
     * is created.
     *
     * @return array (Role|string)[] The user roles
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * Returns the password used to authenticate the user.
     *
     * This should be the encoded password. On authentication, a plain-text
     * password will be salted, encoded, and then compared to this value.
     *
     * @return string The password
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @return mixed
     */
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return mixed
     */
    public function getFullName()
    {
        return $this->fullName;
    }

    /**
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     *
     * @return string|null The salt
     */
    public function getSalt()
    {
        return null;
    }

    /**
     * Returns the username used to authenticate the user.
     *
     * @return string The username
     */
    public function getUsername()
    {
        return $this->userName;
    }

    /**
     * @return mixed
     */
    public function getPosts()
    {
        return $this->posts;
    }

    /**
     * @return Collection
     */
    public function getFollowers()
    {
        return $this->followers;
    }

    /**
     * @return Collection
     */
    public function getFollowing()
    {
        return $this->following;
    }

    /**
     * @return ArrayCollection
     */
    public function getPostsLiked(): ArrayCollection
    {
        return $this->postsLiked;
    }

    /**
     * @return mixed
     */
    public function getConfirmationToken()
    {
        return $this->confirmationToken;
    }

    /**
     * @return mixed
     */
    public function getEnabled()
    {
        return $this->enabled;
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {

    }

    /**
     * String representation of object
     * @link https://php.net/manual/en/serializable.serialize.php
     * @return string the string representation of the object or null
     * @since 5.1.0
     */
    public function serialize()
    {
        return serialize(
            [
                $this->id,
                $this->userName,
                $this->password,
            ]
        );
    }

    /**
     * Constructs the object
     * @link https://php.net/manual/en/serializable.unserialize.php
     * @param string $serialized <p>
     * The string representation of the object.
     * </p>
     * @return void
     * @since 5.1.0
     */
    public function unserialize($serialized)
    {
        list($this->id, $this->userName, $this->password) = unserialize($serialized);
    }

    /**
     * @param mixed $userName
     */
    public function setUserName($userName): void
    {
        $this->userName = $userName;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password): void
    {
        $this->password = $password;
    }

    /**
     * @param mixed $plainPassword
     */
    public function setPlainPassword($plainPassword): void
    {
        $this->plainPassword = $plainPassword;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email): void
    {
        $this->email = $email;
    }

    /**
     * @param mixed $fullName
     */
    public function setFullName($fullName): void
    {
        $this->fullName = $fullName;
    }

    /**
     * @param array $roles
     */
    public function setRoles(array $roles): void
    {
        $this->roles = $roles;
    }

    /**
     * @param mixed $confirmationToken
     */
    public function setConfirmationToken($confirmationToken): void
    {
        $this->confirmationToken = $confirmationToken;
    }

    /**
     * @param mixed $enabled
     */
    public function setEnabled($enabled): void
    {
        $this->enabled = $enabled;
    }

    public function follow(User $user)
    {
        if ($this->getFollowing()->contains($user)) {
            return ;
        }

        $this->getFollowing()->add($user);
    }

    // что бы добавить проверку на это поле при логировании
    // создал класс App\Security\UserChecker
    // и дописал в security.yaml user_checker: App\Security\UserChecker то есть реализовал сервис который
    // сразу после логирования проверяет на true нужное нам свойство
    public function isEnabled()
    {
        return $this->enabled;
    }
}
