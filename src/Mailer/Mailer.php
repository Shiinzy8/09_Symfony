<?php
/**
 * Created by PhpStorm.
 * User: arkhyliuk
 * Date: 12.11.18
 * Time: 18:02
 */

namespace App\Mailer;


use App\Entity\User;

/**
 * Class Mailer
 * @package App\Mailer
 */
class Mailer
{
    /**
     * @var \Swift_Mailer
     */
    private $mailer;
    /**
     * @var \Twig_Environment
     */
    private $twig;
    /**
     * @var string
     */
    private $mailFrom;

    /**
     * Mailer constructor.
     *
     * @param \Swift_Mailer $mailer
     * @param \Twig_Environment $twig
     * @param string $mailFrom
     *
     * mailFrom мы задали как параметр для сервиса в services.yaml передам туда параметр окружения MAIL_FROM
     * из файла .env
     */
    public function __construct(
        \Swift_Mailer $mailer,
        \Twig_Environment $twig,
        string $mailFrom)
    {

        $this->mailer = $mailer;
        $this->twig = $twig;
        $this->mailFrom = $mailFrom;
    }

    /**
     * @param User $user
     *
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function sendConfirmationEmail(User $user)
    {
        $body = $this->twig->render('email/registration.html.twig', [
            'user' => $user,
        ]);

        $message = (new \Swift_Message())->setSubject('Welcome to micro-post app')
            ->setFrom($this->mailFrom)
            ->setTo($user->getEmail())
            ->setBody($body, 'text/html');

        $this->mailer->send($message);
    }

}