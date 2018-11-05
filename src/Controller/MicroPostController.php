<?php
/**
 * Created by PhpStorm.
 * User: arkhyliuk
 * Date: 24.10.18
 * Time: 17:15
 */

namespace App\Controller;


use App\Entity\MicroPost;
use App\Entity\User;
use App\Form\MicroPostType;
use App\Repository\MicroPostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

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
     * @var FlashBagInterface
     */
    private $flashBag;
    /**
     * @var AuthorizationCheckerInterface
     */
    private $authorizationChecker;

    /**
     * MicroPostController constructor.
     * @param \Twig_Environment $twig
     * @param MicroPostRepository $microPostRepository
     * @param FormFactoryInterface $formFactory
     * @param EntityManagerInterface $entityManager
     * @param RouterInterface $router
     * @param FlashBagInterface $flashBag
     * @param AuthorizationCheckerInterface $authorizationChecker
     */
    public function __construct(
        \Twig_Environment $twig, // для работы с шаблонизатором
        MicroPostRepository $microPostRepository, // для работы с репозиторием постов
        FormFactoryInterface $formFactory, // для работы с формами
        EntityManagerInterface $entityManager, // для работы с базой
        RouterInterface $router, // для работы с роутингом
        FlashBagInterface $flashBag, // нужен что б выводить сообщения после редиректов
        AuthorizationCheckerInterface $authorizationChecker // нужен что б давать разрешения на выполнени
    )
    {
        $this->twig = $twig;
        $this->microPostRepository = $microPostRepository;
        $this->formFactory = $formFactory;
        $this->entityManager = $entityManager;
        $this->router = $router;
        $this->flashBag = $flashBag;
        $this->authorizationChecker = $authorizationChecker;
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
     * сюда так же во входные параметры можно было бы передать
     * AuthorizationCheckerInterface $authorizationChecker и испльзовать переменную а не свойство класса
     *
     * @Route("/edit/{id}", name="micro_post_edit")
     *
     * еще один вариант управления доступом через аннотации
     * так же можно добавить такую же аннотацию для целого контроллера
     * @Security("is_granted('edit', microPost)", message="Access denied"))
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
        // только если расширать BaseController
//        $this->denyUnlessGranted('edit', $microPost);

        if (!$this->authorizationChecker->isGranted('edit', $microPost)) {
            throw new UnauthorizedHttpException();
        }

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
     * @Route("/delete/{id}", name="micro_post_delete")
     *
     * @Security("is_granted('delete', microPost)", message="Access denied"))
     *
     * @param MicroPost $microPost
     *
     * @return RedirectResponse
     */
    public function delete(MicroPost $microPost)
    {
        // формирует запрос на удаление записи но не выполняет его
        $microPostId = $microPost->getId();
        $this->entityManager->remove($microPost);
        // а вот эта строка выполнит уже сформированный запрос
        $this->entityManager->flush();

        // хранит в сессис сообщения
        $this->flashBag->add('notice', "You deleted {$microPostId} post");

        return new RedirectResponse(
            $this->router->generate('micro_post_index')
        );
    }

    /**
     * @Route("/add", name="micro_post_add")
     *
     * @Security("is_granted('ROLE_USER')")
     *
     * @param Request $request
     * @param TokenStorageInterface $tokenStorage
     *
     * @return Response|RedirectResponse
     *
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function add(Request $request, TokenStorageInterface $tokenStorage)
    {
        // для анонимного юзера нельзя будет создать пост, надо заполнить в таблице user_id
        // если расширяться от BaseController то будет иметь доступ к такому фукционалу
        // $user = $this->getUser();

        $user = $tokenStorage->getToken()->getUser();

        $microPost = new MicroPost();

        // закомментировали потому что добавили метод public function setTimeOnPersist(): void в MicroPost.php
//        $microPost->setTime(new \DateTime());
        $microPost->setUser($user);

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
     * @Route("/user/{userName}", name="micro_post_user")
     *
     * @param User $userWithPosts
     *
     * @return Response
     *
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function userPosts(User $userWithPosts)
    {
        $html = $this->twig->render('micro-post/index.html.twig', [
//            'posts' => $this->microPostRepository->findBy(
//                ['user' => $userWithPosts,],
//                ['time' => 'DESC']
//            ),

            // благодаря тому что мы создали связь поста и пользователя и передаем пользователя
            // то мы можем получить результат быстрее
            'posts' => $userWithPosts->getPosts(),
        ]);

        return new Response($html);
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