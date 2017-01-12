<?php
namespace AppBundle\Controller;

//use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\ORM\Query\Expr\Join;
//use Symfony\Component\BrowserKit\Response; // add by Andrii 03.01.17
//use Symfony\Bundle\FrameworkBundle\Tests\Fixtures\Validation\Article;
//use Symfony\Component\HttpFoundation\Request;
//use Symfony\Component\HttpFoundation\Response; // add by Andrii 03.01.17
//use AppBundle\Entity\Item;
//use AppBundle\Entity\Category;
//use Symfony\Component\HttpFoundation\Session\Session;

class CategoryController extends Controller
{

    /**
     * show all item of 1 category
     *
     * @Template()
     */
    public function showAction($name)
    {
        $em = $this->getDoctrine()->getManager();
        $qb = $em->createQueryBuilder();
        $qb
            -> select('i')
            -> from('AppBundle\Entity\Item','i')
            -> leftJoin(
                'AppBundle\Entity\Category',
                'c',
                Join::WITH,
                'i.category=c.id'
            )
            ->andWhere('c.name IN (:name)')
            ->setParameter('name',$name);
        $items = $qb->getQuery()->getResult();
        if (!$items) {
            $this->addFlash('success', 'Sorry no items in category, or no such category  ');
            return $this->redirectToRoute('homepage');
        }

        return ['items' => $items];
    }
}