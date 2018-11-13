<?php
/**
 * Created by PhpStorm.
 * User: arkhyliuk
 * Date: 13.11.18
 * Time: 13:27
 */

namespace App\Security;

use App\Entity\User;
use Symfony\Component\Security\Core\Exception\AccountExpiredException;
use Symfony\Component\Security\Core\Exception\AccountStatusException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserChecker implements UserCheckerInterface
{


    public function checkPostAuth(UserInterface $user)
    {
        if (!$user instanceof User) {
            return;
        }

        // user account is expired, the user may be notified
        if (!$user->isEnabled()) {
            throw new AccountExpiredException('Your account is not anabled');
        }
    }

    /**
     * Checks the user account before authentication.
     *
     * @param UserInterface $user
     * @throws AccountStatusException
     */
    public function checkPreAuth(UserInterface $user)
    {
        // TODO: Implement checkPreAuth() method.
    }
}