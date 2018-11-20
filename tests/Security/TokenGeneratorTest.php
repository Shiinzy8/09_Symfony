<?php
/**
 * Created by PhpStorm.
 * User: arkhyliuk
 * Date: 19.11.18
 * Time: 16:32
 */

namespace App\Tests\Security;


use App\Security\TokenGenerator;
use PHPUnit\Framework\TestCase;

class TokenGeneratorTest extends TestCase
{
    /**
     * @throws \Exception
     */
    public function testTokenGeneration()
    {
        $length = 30;
        $message = 'Token contains incorrect characters';

        $token = new TokenGenerator();
        $token = $token->getRandomSecureToken($length);

        $this->assertEquals($length, strlen($token));
        // preg_match return 1 if matched
        $this->assertEquals(1, preg_match("/[A-Za-z0-9]/", $token));

        // этот тест пройдет что неправильно
        $token[15] = '*';
        $this->assertEquals(1, preg_match("/[A-Za-z0-9]/", $token), $message);

        // ctype_alnum check for alphanumeric character(s)
        $this->assertFalse(ctype_alnum($token), $message);
    }
}