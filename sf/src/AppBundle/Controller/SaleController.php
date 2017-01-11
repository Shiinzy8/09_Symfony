<?php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
//use Symfony\Component\BrowserKit\Response; // add comment by Andrii 03.01.17
use Symfony\Bundle\FrameworkBundle\Tests\Fixtures\Validation\Article;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response; // add by Andrii 03.01.17
use AppBundle\Entity\Item;
use AppBundle\Entity\Cart;
use AppBundle\Form\SaleType;
use Symfony\Component\HttpFoundation\Session\Session;

class SaleController extends Controller
{

    /**
     * items list page
     *
     * @Route("/sale" , name="sale")
     * @Template()
     */
    public function indexAction()
    {
        $repo = $this->get('doctrine')->getRepository('AppBundle:Item');

//        for test
//        $repo->findMy(100);
//        dump($repo->findMy(100));

        $items = $repo->findAll();

//        dump($items);

        return compact('items');

//        return [];
//        return $this->render('item/index.html.twig');
//        return new Response("<html><body>items list</body></html>");
    }
}
