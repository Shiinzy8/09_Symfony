<?php
/**
 * Created by PhpStorm.
 * User: arkhyliuk
 * Date: 20.11.18
 * Time: 14:07
 */

namespace App\Tests\Mailer;


use App\Entity\User;
use App\Mailer\Mailer;
use PHPUnit\Framework\TestCase;

class MailerTest extends TestCase
{
    /**
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function testSendConfirmationEmail()
    {
        $user = new User();
        $user->setEmail('john@doe.com');

        $mailerMock = $this->getMockBuilder(\Swift_Mailer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $twigMock = $this->getMockBuilder(\Twig_Environment::class)
            ->disableOriginalConstructor()
            ->getMock();

        $mailer = new Mailer($mailerMock, $twigMock, "me@gmail.com");
        $mailer->sendConfirmationEmail($user);
    }
}