<?php
/**
 * Created by PhpStorm.
 * User: arkhyliuk
 * Date: 09.10.18
 * Time: 18:17
 */

namespace App\Controller;


use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;

/**
 * @Route("/blog")
 *
 * @property SessionInterface session
 */
// class BlockController extends Controller (лучше так не делать)
// если наследоватся от этого класса то в методе index мы сможем достать сервис
// потому что в Controller разрешен к нему доступ, а у AbstractController есть доступ к ограниченному набору сервисов
// (надо смотреть его реелизацию getSubscribedServices())
class BlockController
{
    /**
     * @var \Twig_Environment
     */
    private $twig;

    /**
     * @var SessionInterface
     */
    private $session;
    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * BlockController constructor.
     * @param \Twig_Environment $twig
     * @param SessionInterface $session
     * @param RouterInterface $router
     */
    public function __construct(\Twig_Environment $twig, SessionInterface $session, RouterInterface $router)
    {
        $this->twig = $twig;
        $this->session = $session;
        $this->router = $router;
    }

    /**
// Route("/", name="blog_index") старый вариант без параметра
     * @Route("/", name="blog_index")
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */

// мы можем прокинуть в этот метод Request благодаря actionTypeResolver
// в дальнейшем мы сможем писать свои, но все основывает на типа данных
// public function index(Request $request)
// что б не пробрасывать весь объект Request мы можем изменить роут и добавить в него параметр который прямиком попадет
// в контроллер и вызывать его уже по другому
    public function index()
    {
        $html =  $this->twig->render(
            'blog/index.html.twig',
            [
                'posts' => $this->session->get('posts')
            ]
        );

        return new Response($html);
    }

    /**
     * @Route("/add", name="blog_add")
     */
    public function add()
    {
        $posts = $this->session->get('posts');
        $posts[uniqid()] = [
            'title' => 'A random title ' . rand(1, 100),
            'text' => 'A random text nr ' . rand(1, 200),
            'date' => new \Datetime(),
        ];

        $this->session->set('posts', $posts);

        return new RedirectResponse($this->router->generate('blog_index'));
    }

    /**
     * @Route("/show/{id}", name="blog_show")
     * @param $id
     * @return Response
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function show($id)
    {
        $posts = $this->session->get('posts');
        if (!$posts || !isset($posts[$id])) {
            throw new NotFoundHttpException('Post not found');
        }

        $html = $this->twig->render(
            'blog/post.html.twig',
            [
                'id' => $id,
                'post' => $posts[$id],
            ]
        );

        return new Response($html);
    }
}