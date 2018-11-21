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
        $toEmail = 'john@gmail.com';
        $fromEmail = 'me@gmail.com';
        $mailBody = 'This is message body';

        $user = new User();
        $user->setEmail($toEmail);

        $mailerMock = $this->getMockBuilder(\Swift_Mailer::class)
            ->disableOriginalConstructor()
            ->getMock();

        // проверяем что мейлер один раз вызывает метод send с такими входящими параметрами
        // проблема с проверкой текста сообщения потому что его нельзя вытащить из объекта сообщения \Swift_Message
        // но у него есть метод toString этим мы и воспользуемся
        $mailerMock->expects($this->once())
            ->method('send')
            ->with($this->callback(function ($subject){
                $messageStr = (string)$subject;
                $toEmail = 'john@gmail.com';
                $fromEmail = 'me@gmail.com';
                $mailBody = 'This is message body';
//                dump($messageStr);
//                return true;
                return strpos($messageStr, "From: $fromEmail") !== false
                    && strpos($messageStr, "To: $toEmail") !== false
                    && strpos($messageStr, 'Content-Type: text/html; charset=utf-8') !== false
                    && strpos($messageStr, 'Subject: Welcome to micro-post app') !== false
                    && strpos($messageStr, $mailBody) !== false;
            }));

        $twigMock = $this->getMockBuilder(\Twig_Environment::class)
            ->disableOriginalConstructor()
            ->getMock();
        // проверям что шаблонизатор вызывает один раз метод render с такими входящими параметрами
        $twigMock->expects($this->once())
            ->method('render')
            ->with( 'email/registration.html.twig' , ['user' => $user])
            // сами добавляем занчение которое вернет метод render
            // сами же на него и проверим в mailerMock
            ->willReturn($mailBody);

        $mailer = new Mailer($mailerMock, $twigMock, $fromEmail);
        $mailer->sendConfirmationEmail($user);
    }
}