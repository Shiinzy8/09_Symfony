<?php
namespace AppBundle\Controller;

//use Doctrine\ORM\Mapping\Id;
//use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
//use Symfony\Component\BrowserKit\Response; // add comment by Andrii 03.01.17
//use Symfony\Bundle\FrameworkBundle\Tests\Fixtures\Validation\Article;
//use Symfony\Component\HttpFoundation\Response; // add by Andrii 03.01.17
//use Symfony\Component\HttpFoundation\Session\Session;
use AppBundle\Entity\Sale;
use AppBundle\Entity\Item;
use AppBundle\Entity\Cart;
use AppBundle\Form\SaleType;

class SaleController extends Controller
{

    /**
     * items list page
     *
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $session = $request->getSession();
        $session_params = $session->all();

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
            return $this->redirectToRoute('item_cart');
        }

        $sale = new Sale();

        $user = $this->get('security.token_storage')->getToken()->getUser();
        if($user != "anon.") $sale->setUser($user);

        $form = $this->createForm(SaleType::class, $sale);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($sale);
            foreach ($items as $item) {
                $cart = new Cart();
                $cart->setAmount($item[1]);
                $cart->setItem($item[0]);
                $cart->setSale($sale);
                $em->persist($cart);
            }

            $em->flush();

            $session->clear();

            $this->addFlash('success', 'Order is processed! Our manager will contact you shortly.');

            return $this->redirectToRoute('item_list');
        } else {
            return ['form' => $form->createView()];
        }
    }
}
