<?php
/**
 * Created by PhpStorm.
 * User: arkhyliuk
 * Date: 09.10.18
 * Time: 18:01
 */

namespace App\Service;


use Psr\Log\LoggerInterface;

/**
 * @property LoggerInterface logger
 */
class Greeting
{
    /**
     * Greeting constructor.
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function greet(string $name): string
    {
        $this->logger->info("Greeted $name");
        return "Hello $name";
    }
}