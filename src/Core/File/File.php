<?php

namespace Wauxhall\FileSearcher\Core\File;

use Generator;
use Wauxhall\FileSearcher\Contracts\ILoader;
use Wauxhall\FileSearcher\Contracts\IValidator;
use Wauxhall\FileSearcher\Validation\Validator;
use function Wauxhall\FileSearcher\Helpers\isPathAnUrl;
use function Wauxhall\FileSearcher\Helpers\storage_path;

class File
{
    private $path = null;
    private $file_loader = null;
    private $validator = null;

    /**
     * File constructor.
     * @param string $path
     * @param bool $validation
     */
    public function __construct(string $path, bool $validation = true)
    {
        if(isPathAnUrl($path)) {
            $downloader = new Downloader();
            $path = storage_path() . $downloader->download($path); // download file
        }

        $this->setValidator(new Validator());
        $this->setLoader(new Loader);

        $this->setPath($path, $validation);
    }

    /**
     * @param string $path
     * @param bool $validation
     */
    public function setPath(string $path, bool $validation = true): void
    {
        if($validation) {
            $this->validator->validate($path);
        }

        $this->path = $path;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @param ILoader $loader
     */
    public function setLoader(ILoader $loader): void
    {
        $this->file_loader = $loader;
    }

    public function setValidator(IValidator $validator): void
    {
        $this->validator = $validator;
    }

    public function load(): ?Generator
    {
        return $this->file_loader->load($this->path);
    }
}