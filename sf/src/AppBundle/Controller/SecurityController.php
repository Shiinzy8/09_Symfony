<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
//use Symfony\Component\BrowserKit\Response; // add comment by Andrii 03.01.17
//use Symfony\Component\HttpFoundation\Request;
//use Symfony\Component\HttpFoundation\Response; // add by Andrii 03.01.17

use AppBundle\Entity\User;

class SecurityController extends Controller
{
    /**
     * @Template()
     */
    public function loginAction()
    {
        // достаем сервис аутентификации
        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one, вывести ошибку если она была
        $error = $authenticationUtils->getLastAuthenticationError();

//        dump($error);

        // last username entered by the user, что б не пропал логин, даже если он неправильный
        $lastUsername = $authenticationUtils->getLastUsername();

        return [
            'last_username' => $lastUsername,
            'error'         => $error,
        ];
    }

    public function logoutAction()
    {
        // достаем сервис аутентификации
        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one, вывести ошибку если она была
        $error = $authenticationUtils->getLastAuthenticationError();

//        dump($error);

        // last username entered by the user, что б не пропал логин, даже если он неправильный
        $lastUsername = $authenticationUtils->getLastUsername();

        return [
            'last_username' => $lastUsername,
            'error'         => $error,
        ];
    }
}
