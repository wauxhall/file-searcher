<?php

namespace Wauxhall\FileSearcher\Core;

use Wauxhall\FileSearcher\Contracts\IConfig;

abstract class Config implements IConfig
{
    public static $configs = [];

    /**
     * @param string $config_key
     * @return array
     */
    abstract public function load(string $config_key): array;

    /**
     * Получить значение из конфига
     *
     * @param string $path
     * @return mixed|null
     */
    public static function get(string $path)
    {
        $parts = explode('.', $path);

        if(!isset($parts[0]) || !isset(self::$configs[$parts[0]])) {
            return null;
        }

        $config = array_shift($parts);

        if(empty($parts)) {
            return self::$configs[$config];
        }

        return resolveDotSeparatedPath(self::$configs[$config], implode('.', $parts));
    }
}