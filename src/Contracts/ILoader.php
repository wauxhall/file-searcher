<?php

namespace Wauxhall\FileSearcher\Contracts;

use Generator;

interface ILoader
{
    /**
     * @param string $path
     * @return Generator
     */
    public function load(string $path): Generator;
}