<?php

use PHPUnit\Framework\TestCase;
use Wauxhall\FileSearcher\Core\FileLib;
use Wauxhall\FileSearcher\Core\Config;

class FileLibTest extends TestCase
{
    protected $fileLibAnonClass;

    public function setUp(): void
    {
        $this->fileLibAnonClass = new class extends FileLib {};
    }

    public function testInit(): void
    {
        $this->fileLibAnonClass->initConfig("common", "Yaml");
        $this->fileLibAnonClass->initFile(__DIR__ . "/assets/dummyfile");

        $this->assertNotEmpty(Config::get('common'));
        $this->assertNotNull($this->fileLibAnonClass->getFile());
    }

    public function testInitUnknownConfigClass(): void
    {
        $this->expectException(RuntimeException::class);

        $this->fileLibAnonClass->initConfig('common', 'Conf');
    }
}