<?php

/*
|--------------------------------------------------------------------
| HELPER FUNCTIONS
|--------------------------------------------------------------------
| Функции-хелперы. Общие алгоритмы и геттеры, не привязанные к классам.
*/

/**
 * @param string $config
 * @return string
 */
function config_path(string $config) : string
{
    return __DIR__ . "/../config/" . $config;
}

/**
 * @return string
 */
function storage_path() : string
{
    if (!file_exists(__DIR__ . "/../storage/")) {
        mkdir(__DIR__ . "/../storage/", 0777, true);
    }

    return __DIR__ . "/../storage/";
}

/**
 * @return string
 */
function curl_cert_path() : string
{
    return __DIR__ . "/../cert/cacert-2020-01-01.pem";
}

/**
 * PHP-функция stripos, только ищет ВСЕ вхождения и возвращает массив номеров найденных позиций
 *
 * @param string $haystack
 * @param string $needle
 * @return array
 */
function striposAll(string $haystack, string $needle) : array
{
    $offset = 0;
    $allpos = [];

    while (($pos = stripos($haystack, $needle, $offset)) !== false) {
        $offset   = $pos + 1;
        $allpos[] = $pos;
    }

    return $allpos;
}

/**
 * @param string $path
 * @return bool
 */
function isPathAnUrl(string $path): bool
{
    $path = trim($path);
    if(filter_var($path, FILTER_VALIDATE_URL) !== false && ( strpos( $path, 'http://' ) === 0 || strpos( $path, 'https://' ) === 0 )) {
        return true;
    }

    return false;
}

/**
 * Превращает строку в подмассив массива array. Пример: path.key.value станет [ 'path' => [ 'key' => [ 'value' => ... ] ] ]
 *
 * @param array $array
 * @param string $path
 * @return mixed|null
 */
function resolveDotSeparatedPath(array $array, string $path)
{
    $value = null;
    $parts = explode('.', $path);

    if(empty($parts)) {
        return null;
    }

    foreach($parts as $key) {
        if(is_array($array) && isset($array[$key])) {
            $array = $array[$key];
            $value = $array;
        } else {
            return null;
        }
    }

    return $value;
}