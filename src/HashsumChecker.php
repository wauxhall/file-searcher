<?php

declare(strict_types = 1);

namespace Wauxhall\FileSearcher;

use Wauxhall\FileSearcher\Core\FileLib;

class HashsumChecker extends FileLib
{
    /**
     * HashsumChecker constructor.
     * @param string $filepath
     * @param bool $disable_validation
     */
    public function __construct(string $filepath, bool $disable_validation = false)
    {
        if($disable_validation) {
            $this->disableFileValidation();
        }

        $this->initFile($filepath);
    }

    /**
     * @param string $hash
     * @param string $algo
     * @return bool
     */
    public function check(string $hash, string $algo = 'md5'): bool
    {
        return $hash === hash_file($algo, $this->file->getPath());
    }
}