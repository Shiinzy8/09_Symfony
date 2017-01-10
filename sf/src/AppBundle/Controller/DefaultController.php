<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
//use Symfony\Component\BrowserKit\Response; // add comment by Andrii 03.01.17
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response; // add by Andrii 03.01.17

use AppBundle\Entity\User;

class DefaultController extends Controller
{
    /**
     * @Route("/" , name="homepage")
     * @Template()
     */
    public function indexAction()
    {
//        whatever *your* User object is
//        $user = new User();
//        $plainPassword = 'ryanpass';
//        $encoder = $this->container->get('security.password_encoder');
//        $encoded = $encoder->encodePassword($user, $plainPassword);
//        dump($encoded);

        return [];
//        return new Response('<html><body>hello</body></html>');
//        return $this->render('default/index.html.twig');
    }

    /*
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
        ]);
    }
    */
}
