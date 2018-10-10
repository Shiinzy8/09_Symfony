<?php
/**
 * Created by PhpStorm.
 * User: arkhyliuk
 * Date: 09.10.18
 * Time: 18:17
 */

namespace App\Controller;


use App\Service\Greeting;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @property Greeting greeting
 */
class BlockController extends AbstractController
{

    /**
     * BlockController constructor.
     * @param Greeting $greeting
     */
    public function __construct(Greeting $greeting)
    {
        $this->greeting = $greeting;
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