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
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @property Greeting greeting
 * @property VeryBadDesign badDesign
 */
//class BlockController extends Controller (лучше так не делать)
// если наследоватся от этого класса то в методе index мы сможем достать сервис
// потому что в Controller разрешен к нему доступ, а у AbstractController есть доступ к ограниченному набору сервисов
// (надо смотреть его реелизацию getSubscribedServices())
class BlockController
{

    /**
     * @var Greeting
     */
    private $greeting;

    /**
     * @var \Twig_Environment
     */
    private $twig;

    /**
     * BlockController constructor.
     * @param Greeting $greeting
     * @param \Twig_Environment $twig
     */
    public function __construct(Greeting $greeting, \Twig_Environment $twig)
    {
        $this->greeting = $greeting;
        $this->twig = $twig;
    }

    /**
// Route("/", name="block_index") старый вариант без параметра
     * @Route("/{name}", name="block_index")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */

    // мы можем прокинуть в этот метод Request благодаря actionTypeResolver
    // в дальнейшем мы сможем писать свои, но все основывает на типа данных
//    public function index(Request $request)
// что б не пробрасывать весь объект Request мы можем изменить роут и добавить в него параметр который прямиком попадет
// в контроллер и вызывать его уже по другому
    public function index($name)
    {
//        $this->get('app.greeting');
        $html =  $this->twig->render('base.html.twig', ['message' => $this->greeting->greet(
//            $request->get('name')
            $name
        )]);

        return new Response($html);
    }
}