<?php
namespace AppBundle\Controller;

//use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
//use Symfony\Component\BrowserKit\Response; // add comment by Andrii 03.01.17
//use Symfony\Bundle\FrameworkBundle\Tests\Fixtures\Validation\Article;
//use Symfony\Component\HttpFoundation\Response; // add by Andrii 03.01.17
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Item;
use AppBundle\Form\ItemType;
use Symfony\Component\HttpFoundation\Session\Session;

class ItemController extends Controller
{

    /**
     * items list page
     *
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
     * one item page by id
     * {sl} - for trailing slash if its needed
     *
     * @Template()
     */
    public function showAction($id) // or Request $request)
    {
//        $id = $request->get('id');

        $item = $this->get('doctrine')->getRepository('AppBundle:Item')->find($id);

        if (!$item) {
            throw $this->createNotFoundException('Page not found!');
        }

        return compact('item');

//        return $this->render('item/show.html.twig',['id_item_for_twig' => $id]);
//        return new Response("<html><body>item page : {$id} </body></html>");
    }

    /**
     * edit one item
     *
     * @Template()
     */
    public function editAction(Request $request)
    {
        $id = $request->get('id');
        $item = $this->get('doctrine')->getRepository('AppBundle:Item')->find($id);

        $form = $this->createForm(ItemType::class,$item); // connection with form

        $form->handleRequest($request); // what we put in form

        if ($form->isSubmitted() && $form->isValid()) {

            $em=$this->get('doctrine')->getManager();

            $em->persist($item); // подготовка к сохранению в базе
            $em->flush(); // сохранить все подготовленные объекты

            $this->addFlash("success","Form saved successfully");
            return $this->redirectToRoute('item_edit', ['id' => $id]);
        }

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
     * add one new item
     *
     * @Template()
     */
    public function addAction(Request $request)
    {
        $item = new Item();
        $form = $this->createForm(ItemType::class,$item); // connection with form
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
     * items list page
     *
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

    /**
     * cart list page
     *
     * @Template()
     */
    public function cartAction(Request $request)
    {
        $request_params= $request->request->all(); // получили все параметры из запроса
        $session = $this->get('session'); // вызвали сессию

        // проверили пустой ли массив с параметрами
        if (!empty($request_params) && $request->get('amount')>0) {

//            $form = $request;

            $id = $request->get('item_id'); // записали
            $amount = $request->get('amount') + 0; // записали

            // проверяем существует ли такой ключ в сессии
            if($session->has($id)) {
                $session_amount = $session->get($id); // достаем значение
                $amount = $amount + $session_amount;
            }

            $session->set($id,$amount);
            //return $this->redirectToRoute('item_list');
        }

        $session_params = $session->all(); // возвращаем все парамерты из сессии

        $items = [];
        $count = 0;
        foreach ($session_params as $key => $value) {
            $key = 0 + $key;
            if (!$key) {
                continue;
            }
            $count++;
            $item = $this->get('doctrine')->getRepository('AppBundle:Item')->find($key);
            if (!$item) {
                throw $this->createNotFoundException('Page not found!');
            }
            $items[$key] = [$item, $value];
        }
        if ($count == 0) {
            $this->addFlash('success', 'no purchases');
            return [];
        }

        return ['items' => $items];
    }

    /**
     * cart changed list page
     */
    public function changeAction(Request $request)
    {
        $request_params = $request->request->all(); // получили все параметры из запроса
        $session = $this->get('session'); // вызвали сессию

        // проверили пустой ли массив с параметрами
        if (!empty($request_params)) {

            $form = $request;

            $id = $request->get('item_id'); // записали
            $amount = $request->get('amount') + 0; // записали

            // проверяем количество
            if ($amount <= 0) {
                $session->remove($id); // удаляем значение
            } else {
                $session->set($id, $amount);
            }
        }
            return $this->redirectToRoute('item_cart');
    }
}
