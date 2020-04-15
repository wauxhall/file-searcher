<?php

use PHPUnit\Framework\TestCase;
use Wauxhall\FileSearcher\Core\File\Downloader;
use function Wauxhall\FileSearcher\Helpers\storage_path;

class DownloaderTest extends TestCase
{
    protected $downloader;

    public function setUp(): void
    {
        $this->downloader = new Downloader();
    }

    public function testDownload()
    {
        $url = "https://www.dropbox.com/s/3wtor9hhses4hfv/dummyfile?dl=1";

        $filename = storage_path() . $this->downloader->download($url);

        $this->assertFileExists($filename);
        $this->assertStringNotEqualsFile($filename, '');
    }

    public function testDownloadFailPathNotAnUrl()
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionCode(4221);

        $this->downloader->download("I'm an url, honestly");
    }

    public function testDownloadFailBadHost()
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionCode(5003);

        $filename = storage_path() . $this->downloader->download("https://fjjskc.fjj");

        $this->assertFileNotExists($filename);
    }

    public function testDownloadFailBadHttpCode()
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionCode(5004);

        $filename = storage_path() . $this->downloader->download("https://refactoring.guru/ru/design-patterns/factory-method/a");

        $this->assertFileNotExists($filename);
    }
}