<?php
/**
 * Created by PhpStorm.
 * User: arkhyliuk
 * Date: 24.10.18
 * Time: 17:15
 */

namespace App\Controller;


use App\Entity\MicroPost;
use App\Form\MicroPostType;
use App\Repository\MicroPostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;

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
     * @var FormFactoryInterface
     */
    private $formFactory;
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * MicroPostController constructor.
     * @param \Twig_Environment $twig
     * @param MicroPostRepository $microPostRepository
     * @param FormFactoryInterface $formFactory
     * @param EntityManagerInterface $entityManager
     * @param RouterInterface $router
     */
    public function __construct(
        \Twig_Environment $twig,
        MicroPostRepository $microPostRepository,
        FormFactoryInterface $formFactory,
        EntityManagerInterface $entityManager,
        RouterInterface $router)
    {
        $this->twig = $twig;
        $this->microPostRepository = $microPostRepository;
        $this->formFactory = $formFactory;
        $this->entityManager = $entityManager;
        $this->router = $router;
    }

    /**
     * @Route("/", name="micro_post_index")
     *
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function index()
    {
        $html = $this->twig->render('micro-post/index.html.twig', [
//            'posts' => $this->microPostRepository->findAll()
            'posts' => $this->microPostRepository->findBy([], ['time' => 'DESC']),
        ]);

        return new Response($html);
    }


    /**
     * @Route("/edit/{id}", name="micro_post_edit")
     *
     * @param MicroPost $microPost
     * @param Request $request
     *
     * @return RedirectResponse|Response
     *
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function edit(MicroPost $microPost, Request $request)
    {
        $form = $this->formFactory->create( MicroPostType::class, $microPost);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
//            $this->entityManager->persist($microPost);
            $this->entityManager->flush();

            return new RedirectResponse($this->router->generate('micro_post_index'));
        }

        return new Response(
            $this->twig->render('micro-post/add.html.twig', [
                'form' => $form->createView(),
            ])
        );
    }

    /**
     * @Route("/add", name="micro_post_add")
     *
     * @param Request $request
     *
     * @return Response|RedirectResponse
     *
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function add(Request $request)
    {
        $microPost = new MicroPost();
        $microPost->setTime(new \DateTime());

        // что бы создать экземпляр формы на странице нам надо подключить новый сервис в конструкторе
        // сервис $formFactory
        // первый аргумент это класс который реализует форму
        // а второй данные для формы если хотим что б какие то поля были заполлнены
        $form = $this->formFactory->create( MicroPostType::class, $microPost);

        // если форму сабмитнули то данные метод сработает и обработает данные которые передал пользователь
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // делаем так же как в фикстурах сначала генерируем запросы
            $this->entityManager->persist($microPost);
            // потом их выполняем
            $this->entityManager->flush();

            // после того как мы сохраним пост нам надо перебросить пользователя на страницу всех постов
            // но что это сделать нам нужен сервис с роутами его надо передать как параметр в конструктор класса
            return new RedirectResponse($this->router->generate('micro_post_index'));
        }

        // очень важно вызывать form->createView после handleRequest
        // так же наша форма не будет использовать стили bootstrap
        // для того что б это исправить надо в twig.yaml добавить строку form_themes:['bootstrap_4_layout.html.twig']

        return new Response(
            $this->twig->render('micro-post/add.html.twig', [
                'form' => $form->createView(),
            ])
        );
    }

    /**
     * @Route("/{id}", name="micro_post_post")
     *
     * @param MicroPost $post
     *
     * @return Response
     *
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function post(MicroPost $post)
//    public function post($id)
// второй способ задать параметр на вход для метода
//
    {
//        по скольку мы задали входным параметром $post то симфони будет искать ключевое поле в Entity
//        и сразу искать запись post с таким id, если не найдет вернет 404
//        проверить что симфони правильно делает запрос можно в дев тулзах пункт Doctrine
//        $post = $this->microPostRepository->find($id);

        return new Response(
            $this->twig->render(
                'micro-post/post.html.twig', [
                    'post' => $post
                ]
            )
        );
    }
}