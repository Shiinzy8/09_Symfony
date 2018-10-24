<?php
/**
 * Created by PhpStorm.
 * User: arkhyliuk
 * Date: 24.10.18
 * Time: 17:15
 */

namespace App\Controller;


use App\Repository\MicroPostRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class MicroPostController
 * @package App\Controller
 *
 * @Route("/micro_post")
 */
class MicroPostController
{
    /**
     * @var \Twig_Environment
     */
    private $twig;
    /**
     * @var MicroPostRepository
     */
    private $microPostRepository;

    /**
     * MicroPostController constructor.
     * @param \Twig_Environment $twig
     * @param MicroPostRepository $microPostRepository
     */
    public function __construct(\Twig_Environment $twig, MicroPostRepository $microPostRepository)
    {

        $this->twig = $twig;
        $this->microPostRepository = $microPostRepository;
    }

    /**
     * @Route("/", name="micro_post_index")
     */
    public function index()
    {
        $html = $this->twig->render('micro-post/index.html.twig', [
            'posts' => $this->microPostRepository->findAll()
        ]);

        return new Response($html);
    }

}