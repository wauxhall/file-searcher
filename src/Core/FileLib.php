<?php

namespace Wauxhall\FileSearcher\Core;

use RuntimeException;
use Wauxhall\FileSearcher\Core\File\File;

abstract class FileLib
{
    protected $file = null;
    protected $validation = true;

    public function disableFileValidation()
    {
        $this->validation = false;
    }

    public function enableFileValidation()
    {
        $this->validation = true;
    }

    /**
     * @param string $key
     * @param string $type
     */
    public function initConfig(string $key, string $type): void
    {
        $classname = "\Wauxhall\FileSearcher\Core\Config\\" . $type;

        if(!class_exists($classname)) {
            throw new RuntimeException("Неизвестный тип конфига");
        }

        $config = new $classname();
        $config->load($key);
    }

    /**
     * @param string $filepath
     */
    public function initFile(string $filepath): void
    {
        $this->file = new File($filepath, $this->validation);
    }

    /**
     * @return mixed
     */
    public function getFile()
    {
        return $this->file;
    }
}