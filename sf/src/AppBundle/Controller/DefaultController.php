<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
//use Symfony\Component\BrowserKit\Response; // add comment by Andrii 03.01.17
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response; // add by Andrii 03.01.17

class DefaultController extends Controller
{
    /**
     * @Route("/" , name="homepage")
     */
    public function indexAction()
    {
//        return new Response('<html><body>hello</body></html>');
        return $this->render('default/index.html.twig');
    }
//    public function indexAction(Request $request)
//    {
//        // replace this example code with whatever you need
//        return $this->render('default/index.html.twig', [
//            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
//        ]);
//    }

}
