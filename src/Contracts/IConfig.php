<?php

namespace Wauxhall\FileSearcher\Contracts;

interface IConfig
{
    /**
     * @param string $config_key
     * @return array
     */
    public function load(string $config_key): array;
}