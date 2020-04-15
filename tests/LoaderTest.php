<?php

use PHPUnit\Framework\TestCase;
use Wauxhall\FileSearcher\Core\File\Loader;

class LoaderTest extends TestCase
{
    private $loader;

    protected function setUp(): void
    {
        $this->loader = new Loader();
    }

    public function testLoad()
    {
        $file = $this->loader->load(__DIR__ . "/assets/dummyfile");
        $this->assertIsIterable($file);

        $file_contents = '';

        foreach($file as $line) {
            $file_contents .= $line;
        }

        $this->assertStringContainsString("Hello", $file_contents);
    }
}