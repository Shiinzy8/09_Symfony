<?php
/**
 * Created by PhpStorm.
 * User: arkhyliuk
 * Date: 08.11.18
 * Time: 14:12
 */

namespace App\Controller;


use App\Entity\MicroPost;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * Class LikesController
 * @package App\Controller
 *
 * @Route("/likes", name="")
 */
class LikesController extends Controller
{

    /**
     *
     * @Route("/like/{id}", name="likes_like")
     *
     * @param MicroPost $microPost
     *
     * @return JsonResponse
     */
    public function like(MicroPost $microPost)
    {
        /** @var User $currentUser */
        $currentUser = $this->getUser();

        if(!$currentUser instanceof User) {
            return new JsonResponse([], Response::HTTP_UNAUTHORIZED);
        }

        $microPost->like($currentUser);
        $this->getDoctrine()->getManager()->flush();

        return new JsonResponse([
            'count' => $microPost->getLikeBy()->count(),
            Response::HTTP_OK
        ]);
    }

    /**
     * @Route("/unlike/{id}", name="likes_unlike")
     * @param MicroPost $microPost
     * @return JsonResponse
     */
    public function unlike(MicroPost $microPost)
    {
        /** @var User $currentUser */
        $currentUser = $this->getUser();

        if(!$currentUser instanceof User) {
            return new JsonResponse([], Response::HTTP_UNAUTHORIZED);
        }

        $microPost->getLikeBy()->removeElement($currentUser);
        $this->getDoctrine()->getManager()->flush();

        return new JsonResponse([
            'count' => $microPost->getLikeBy()->count(),
            Response::HTTP_OK
        ]);
    }
}