<?php

declare(strict_types = 1);

namespace Wauxhall\FileSearcher;

use Wauxhall\FileSearcher\Core\FileLib;

class FileSearcher extends FileLib
{
    /**
     * FileSearcher constructor.
     * @param string $filepath
     * @param bool $disable_validation
     */
    public function __construct(string $filepath, bool $disable_validation = false)
    {
        if($disable_validation) {
            $this->disableFileValidation();
        }

        $this->initConfig('common', 'Yaml');
        $this->initFile($filepath);
    }

    /**
     * @param string $searchString
     * @return array
     */
    public function search(string $searchString): array
    {
        $file = $this->file->load();

        $found = [];

        foreach($file as $key => $line) {
            $search_positions = striposAll($line, $searchString);

            if(!empty($search_positions)) {
                $found[$key] = $search_positions;
            }
        }

        return $found;
    }
}