<?php

namespace Wauxhall\FileSearcher\Core\Config;

use RuntimeException;
use Wauxhall\FileSearcher\Core\Config;
use function Wauxhall\FileSearcher\Helpers\config_path;

class Yaml extends Config
{
    /**
     * @param string $config_key
     * @return array
     */
    public function load(string $config_key): array
    {
        $config = \Spyc::YAMLLoad(config_path($config_key . '.yaml'));

        if(isset($config[0]) && $config[0] == config_path($config_key . '.yaml')) {
            throw new RuntimeException("Не удалось загрузить конфиг " . $config_key . ".yaml");
        }

        self::$configs[$config_key] = $config;

        return $config;
    }
}