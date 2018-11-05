<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert; // для создания кастомных валидаций

/**
 * @ORM\Entity(repositoryClass="App\Repository\MicroPostRepository")
 *
 * важная аннотация для того что б использовать callback функции
 * @ORM\HasLifecycleCallbacks()
 */
class MicroPost
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * занчит это поле будет полем таблицы, если его не указать в таблицу это поле не попадет
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=280)
     * @Assert\NotBlank() добавляем способы проверки вручную
     * @Assert\Length(min=10, minMessage="to short text, message is set with annotation in Entity\MicroPost")
     */
    private $text;

    /**
     * @ORM\Column(type="datetime")
     */
    private $time;

    /**
     * поле posts мы создадим в таблице user, в entity надо добавить соответствующий параметр
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="posts")
     *
     * для создания столбца который будет показывать id пользователя ссылаясь на таблицу пользвателей
     * @ORM\JoinColumn(nullable=false)
     * @var
     */
    private $user;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param mixed $text
     */
    public function setText($text): void
    {
        $this->text = $text;
    }

    /**
     * @return mixed
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * @param mixed $time
     */
    public function setTime($time): void
    {
        $this->time = $time;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user): void
    {
        $this->user = $user;
    }

    /**
     * Значит будет вызыватся каждый раз мерез методом persist()
     * @ORM\PrePersist()
     */
    public function setTimeOnPersist(): void
    {
        $this->time = new \DateTime();
    }
}
