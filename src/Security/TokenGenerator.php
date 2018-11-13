<?php
/**
 * Created by PhpStorm.
 * User: arkhyliuk
 * Date: 12.11.18
 * Time: 18:39
 */


namespace App\Security;

class TokenGenerator
{
    private const ALPHABET = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';

    /**
     * @param int $length
     *
     * @return string
     *
     * @throws \Exception
     */
    public function getRandomSecureToken(int $length): string
    {
        $maxNumber = strlen(self::ALPHABET) - 1;
        $token = '';

        for ($i = 0; $i < $length; $i++) {
            $token .= self::ALPHABET[random_int(0, $maxNumber)];
        }

        return $token;
    }
}