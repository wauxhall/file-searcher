<?php

namespace Wauxhall\FileSearcher\Core\File;

use RuntimeException;
use Wauxhall\FileSearcher\Contracts\IDownloader;
use function Wauxhall\FileSearcher\Helpers\curl_cert_path;
use function Wauxhall\FileSearcher\Helpers\isPathAnUrl;
use function Wauxhall\FileSearcher\Helpers\storage_path;

class Downloader implements IDownloader
{
    /**
     * @param string $url
     * @return string
     */
    public function download(string $url): string
    {
        if(!isPathAnUrl($url)) {
            throw new RuntimeException("Указан неверный url для загрузки!", 4221);
        }

        set_time_limit(0);

        $filename = parse_url($url, PHP_URL_HOST) . '_' . date("m.d_H.i.s");

        $fp = fopen(storage_path() . $filename, 'w+b');

        if(!$fp) {
            throw new RuntimeException("Не удалось открыть/создать временный файл для записи. Проверьте права на запись в папке storage. Текст ошибки: " . json_encode(error_get_last()), 5001);
        }

        $ch = curl_init($url);

        if (!$ch) {
            throw new RuntimeException ( 'Ошибка инициализации curl. Текст ошибки: ' . json_encode(error_get_last()), 5002);
        }

        curl_setopt($ch, CURLOPT_TIMEOUT, 75);
        curl_setopt($ch, CURLOPT_FILE, $fp);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

        curl_setopt($ch, CURLOPT_CAINFO, curl_cert_path());
        curl_setopt($ch, CURLOPT_CAPATH, curl_cert_path());

        if(curl_exec($ch) === false) {
            $errormsg = curl_error($ch);

            curl_close($ch);
            fclose($fp);
            unlink(storage_path() . $filename);

            throw new RuntimeException("Не удалось выполнить запрос к " . $url . ". Текст ошибки: " . $errormsg, 5003);

        } elseif( ($code = curl_getinfo($ch, CURLINFO_HTTP_CODE)) != 200 ) {
            curl_close($ch);
            fclose($fp);
            unlink(storage_path() . $filename);

            throw new RuntimeException($url . " вернул ответ с кодом " . $code, 5004);
        }

        curl_close($ch);

        fclose($fp);

        return $filename;
    }
}