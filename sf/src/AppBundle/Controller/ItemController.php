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

class ItemController extends Controller
{

    /**
     * items list page
     *
     * @Route("/item" , name="item_list")
     * @Template()
     */
    public function indexAction()
    {
        return [];

//        return $this->render('item/index.html.twig');
//        return new Response("<html><body>items list</body></html>");
    }

    /**
     * one item page by id
     *
     * @Route("/item/{id}{sl}" , name="item_page" , requirements={"id":"[1-9][0-9]*", "sl":"/?"})
     * @Template()
     *
     * @param $id
     * @return Response
     * @internal param Request $request or simple $id
     */
    public function showAction($id) // or Request $request)
    {
//        $id = $request->get('id');

        return ['id' => $id];

//        return $this->render('item/show.html.twig',['id_item_for_twig' => $id]);
//        return new Response("<html><body>item page : {$id} </body></html>");
    }

    /**
     * items list page
     *
     * @Route("/item-test{sl}" , name="item_test_action" , requirements={"sl":"/?"})
     * @Template()
     */
    public function testAction()
    {
        $item = new Item();
        $item->setName('First item name')->setPrice('100')->setContent('Some <b>text</b> ');
        dump($item); // include in Symfony

        return['item'=>$item];


//        return $this->render('item/test.html.twig',['item'=>$item]);
//        return new Response("<html><body>items list</body></html>");
    }

}
