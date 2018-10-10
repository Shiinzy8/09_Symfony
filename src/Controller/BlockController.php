<?php
/**
 * Created by PhpStorm.
 * User: arkhyliuk
 * Date: 09.10.18
 * Time: 18:17
 */

namespace App\Controller;


use App\Service\Greeting;
use App\Service\VeryBadDesign;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @property Greeting greeting
 * @property VeryBadDesign badDesign
 */
class BlockController extends AbstractController
{

    /**
     * @var Greeting
     */
    private $greeting;

    /**
     * @var VeryBadDesign
     */
    private $badDesign;

    /**
     * BlockController constructor.
     * @param Greeting $greeting
     * @param VeryBadDesign $badDesign
     */
    public function __construct(Greeting $greeting, VeryBadDesign $badDesign)
    {
        $this->greeting = $greeting;
        $this->badDesign = $badDesign;
    }

    /**
     * @Route("/", name="block_index")
     */
    public function index(Request $request)
    {
        return $this->render('base.html.twig', ['message' => $this->greeting->greet(
            $request->get('name')
        )]);
    }
}