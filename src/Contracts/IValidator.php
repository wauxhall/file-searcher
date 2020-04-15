<?php

namespace Wauxhall\FileSearcher\Contracts;

interface IValidator
{
    /**
     * @param string $filepath
     * @return mixed
     */
    public function validate(string $filepath);
}