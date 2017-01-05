<?php

namespace AppBundle\Service;

class TextExporter
{
    private $exportDir;

    public function __construct($exportDir)
    {
        $this->exportDir = $exportDir;
        if (!file_exists($this->exportDir)) {
            mkdir($this->exportDir, 755);
        }
    }

    public function export(Item $item)
    {
        
//        return 'hello';
    }
}