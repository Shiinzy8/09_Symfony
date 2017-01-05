<?php

namespace AppBundle\Service;

use Psr\Log\LoggerInterface; // to extend standard service
use AppBundle\Entity\Item;

class TextExporter
{
    private $exportDir;

    private $logger;

    public function __construct(LoggerInterface $logger, $exportDir)
    {
        $this->exportDir = $exportDir;
        $this->logger = $logger;
        if (!file_exists($this->exportDir)) {
            mkdir($this->exportDir, 755);
        }
    }

    public function export(Item $item)
    {
        file_put_contents($this->exportDir . '/' . $item->getName(). '.txt', $item->getContent());
        $this->logger->info('Log created by Shon');
//        return 'hello';
    }
}