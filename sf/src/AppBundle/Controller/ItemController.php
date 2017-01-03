<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
//use Symfony\Component\BrowserKit\Response; // add comment by Andrii 03.01.17
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response; // add by Andrii 03.01.17

class ItemController extends Controller
{

    /**
     * items list page
     *
     * @Route("/item{sl}" , name="item_list" , requirements={"sl":"/?"})
     */
    public function indexAction()
    {
        return $this->render('item/index.html.twig');
//        return new Response("<html><body>items list</body></html>");
    }

    /**
     * one item page by id
     *
     * @Route("/item/{id}{sl}" , name="item_page" , requirements={"id":"[1-9][0-9]*", "sl":"/?"})
     *
     * @param Request $request or simple $id
     * @return Response
     */
    public function showAction($id) // or Request $request)
    {
//        $id = $request->get('id');


        return $this->render('item/show.html.twig',['id_item_for_twig' => $id]);
//        return new Response("<html><body>item page : {$id} </body></html>");
    }

    /**
     * items list page
     *
     * @Route("/item-test{sl}" , name="item_test_action" , requirements={"sl":"/?"})
     */
    public function testAction()
    {
        return $this->render('item/test.html.twig');
//        return new Response("<html><body>items list</body></html>");
    }

}
