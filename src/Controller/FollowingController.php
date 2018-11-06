<?php
/**
 * Created by PhpStorm.
 * User: arkhyliuk
 * Date: 06.11.18
 * Time: 15:42
 */

namespace App\Controller;


use App\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Security("is_granted('ROLE_USER')")
 *
 * @Route("/following")
 *
 * Class FollowingController
 * @package App\Controller
 */
class FollowingController extends Controller
{
    /**
     * @Route("/follow/{id}", name="following_follow")
     *
     * @param User $userToFollow
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function following(User $userToFollow)
    {
        /** @var User $currentUser */
        $currentUser = $this->getUser();
        $currentUser->getFollowing()->add($userToFollow);

        $this->getDoctrine()->getManager()->flush();

        return $this->redirectToRoute('micro_post_user', ['userName' => $userToFollow->getUsername()]);
    }

    /**
     * @Route("/unfollow/{id}", name="following_unfollow")
     *
     * @param User $userToUnfollow
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function unfollowing(User $userToUnfollow)
    {
        /** @var User $currentUser */
        $currentUser = $this->getUser();
        $currentUser->getFollowing()->removeElement($userToUnfollow);

        $this->getDoctrine()->getManager()->flush();

        return $this->redirectToRoute('micro_post_user', ['userName' => $userToUnfollow->getUsername()]);
    }
}