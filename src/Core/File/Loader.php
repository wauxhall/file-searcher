<?php

namespace Wauxhall\FileSearcher\Core\File;

use Generator;
use Wauxhall\FileSearcher\Contracts\ILoader;

class Loader implements ILoader
{
    /**
     * @param string $path
     * @return Generator
     */
    public function load(string $path): Generator
    {
        $handle = fopen($path, "r");

        while(!feof($handle)) {
            yield trim(fgets($handle));
        }

        fclose($handle);
    }
}