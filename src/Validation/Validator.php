<?php

namespace Wauxhall\FileSearcher\Validation;

use finfo;
use LogicException;
use Wauxhall\FileSearcher\Contracts\IValidator;
use Wauxhall\FileSearcher\Core\Config;

class Validator implements IValidator
{
    /**
     * @param string $path
     * @return bool|null
     */
    public function validate(string $path): ?bool
    {
        if(!$this->doesFileExist($path)) {
            throw new LogicException("Ошибка: указанного файла не существует", 404);
        }

        $mime = $this->getMimeType($path);
        $size = $this->getSize($path);

        $allowed_mimes = Config::get("common.validation.allowed_mime_types");

        if(is_array($allowed_mimes) && !in_array($mime, $allowed_mimes)) {
            throw new LogicException("Ошибка валидации: обработка файлов с mime-типом " . $mime . " не разрешена", 4221);
        }

        $max_size = Config::get("common.validation.max_size");
        $min_size = Config::get("common.validation.min_size");

        if($size > $max_size || $size < $min_size) {
            throw new LogicException("Ошибка валидации: файл должен быть больше " . $min_size . " и меньше " . $max_size . " байт", 4222);
        }

        return true;
    }

    /**
     * @param string $path
     * @return bool
     */
    public function doesFileExist(string $path): bool
    {
        if(!file_exists($path) || is_dir($path)) {
            return false;
        }

        return true;
    }

    /**
     * @param string $path
     * @return string
     */
    public function getMimeType(string $path)
    {
        $finfo = new finfo(FILEINFO_MIME_TYPE);

        return $finfo->file($path);
    }

    /**
     * @param string $path
     * @return false|int
     */
    public function getSize(string $path)
    {
        return filesize($path);
    }
}