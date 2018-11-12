<?php
/**
 * Created by PhpStorm.
 * User: arkhyliuk
 * Date: 30.10.18
 * Time: 13:47
 */

namespace App\Controller;


use App\Entity\User;
use App\Event\UserRegisterEvent;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class RegisterController
 * @package App\Controller
 */
class RegisterController extends Controller
{
    /**
     * @Route("/register", name="user_register")
     *
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function register(
        UserPasswordEncoderInterface $passwordEncoder,
        Request $request,
        EventDispatcherInterface $eventDispatcher)
    {
        // поскольку мы расширяем базовый класс то мы могли бы написать так
        // правда тогда надо было бы пробросить $microPost
//        $this->denyAccessUnlessGranted('edit', $microPost);

        $user = new User();

        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $password = $passwordEncoder->encodePassword(
                $user,
                $user->getPlainPassword()
            );
            $user->setPassword($password);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            $userRegisteredEvent = new UserRegisterEvent($user);

            $eventDispatcher->dispatch(UserRegisterEvent::NAME, $userRegisteredEvent);

            return $this->redirectToRoute('micro_post_index');
        }

        return $this->render('register/register.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}