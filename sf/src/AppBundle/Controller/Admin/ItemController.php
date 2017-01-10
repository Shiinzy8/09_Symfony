<?php

namespace AppBundle\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
//use Symfony\Component\BrowserKit\Response; // add comment by Andrii 03.01.17
use Symfony\Bundle\FrameworkBundle\Tests\Fixtures\Validation\Article;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response; // add by Andrii 03.01.17
use AppBundle\Entity\Item;
use AppBundle\Form\ItemType;

class ItemController extends Controller
{

    /**
     * admin items list page
     *
     * @Route("/admin/item" , name="admin_item_list")
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

    /**
     * admin item page
     *
     * @Route("/admin/item/{id}{sl}" , name="admin_item_page" , defaults={"sl":"","id":""} , requirements={"id":"[1-9][0-9]*", "sl":"/?"})
     * @Template()
     */
    public function showAction($id) // or Request $request)
    {
//        $id = $request->get('id');

        $item = $this->get('doctrine')->getRepository('AppBundle:Item')->find($id);
        if (!$item) {
            throw $this->createNotFoundException('Page not found!');
        }

//        dump($item);

        $exporter = $this->get('text_export');
        $exporter->export($item);

//        dump($item);
//        return compact('id');

        return ['item'=>$item];

//        return $this->render('item/show.html.twig',['id_item_for_twig' => $id]);
//        return new Response("<html><body>item page : {$id} </body></html>");
    }

    /**
     * admin edit one item
     *
     * @Route("/admin/item/edit/{id}" , name="admin_item_edit" , defaults={"id":""} , requirements={"id":"[1-9][0-9]*"})
     * @Template()
     */
    public function editAction(Request $request)
    {
        $id = $request->get('id');
        $item = $this->get('doctrine')->getRepository('AppBundle:Item')->find($id);

        $form = $this->createForm(ItemType::class,$item); // connection with form
//        dump($item);

        $form->handleRequest($request); // what we put in form

        if ($form->isSubmitted() && $form->isValid()) {

            //$doctrine=$this->get('doctrine');
            $em=$this->get('doctrine')->getManager();

            $em->persist($item); // подготовка к сохранению в базе
            $em->flush(); // сохранить все подготовленные объекты

            $this->addFlash("success","Form saved successfully");
            return $this->redirectToRoute('item_edit', ['id' => $id]);
        }

//        dump($item, $form->isSubmitted(), $form->isValid());

        if (!$item) {
            throw $this->createNotFoundException('Page not found!');
        }

//        dump($em); // include in Symfony
//        $form->createView(); - для передачи в рендар значений формы

        return ['item'=>$item,'form'=>$form->createView()];

//        return $this->render('item/test.html.twig',['item'=>$item]);
//        return new Response("<html><body>items list</body></html>");
    }

    /**
     * admin add one new item
     *
     * @Route("/admin/item/add" , name="admin_item_add")
     * @Template()
     */
    public function addAction(Request $request)
    {
        $item = new Item();
        $form = $this->createForm(ItemType::class,$item); // connection with form
//        dump($item);
        $form->handleRequest($request); // what we put in form

        if ($form->isSubmitted() && $form->isValid()) {
            //$doctrine=$this->get('doctrine');
            $em=$this->get('doctrine')->getManager();
            $em->persist($item); // подготовка к сохранению в базе
            $em->flush(); // сохранить все подготовленные объекты
            $this->addFlash("success","Form saved successfully");
            return $this->redirectToRoute('item_list');
        }

        return ['item'=>$item,'form'=>$form->createView()];
    }

    /**
     * admin item test page
     *
     * @Route("/admin/item/test" , name="admin_item_test_action")
     * @Template()
     */
    public function testAction()
    {
        $item = new Item();
        $item->setName('First item name')->setPrice('100')->setContent('Some <b>text</b> ');

        //$doctrine=$this->get('doctrine');
        $em=$this->get('doctrine')->getManager();

        $em->persist($item); // подготовка к сохранению в базе
        $em->flush(); // сохранить все подготовленные объекты

//        dump($em); // include in Symfony

        return ['item'=>$item];

//        return $this->render('item/test.html.twig',['item'=>$item]);
//        return new Response("<html><body>items list</body></html>");
    }

}
