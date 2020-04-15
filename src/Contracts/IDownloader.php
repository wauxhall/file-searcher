<?php

namespace Wauxhall\FileSearcher\Contracts;

interface IDownloader
{
    /**
     * @param string $url
     * @return string
     */
    public function download(string $url): string;
}