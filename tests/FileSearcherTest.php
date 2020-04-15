<?php

use PHPUnit\Framework\TestCase;
use Wauxhall\FileSearcher\FileSearcher;

class FileSearcherTest extends TestCase
{
    public function testSearch(): void
    {
        $searcher = new FileSearcher(__DIR__ . "/assets/dummyfile");

        $this->assertEquals([
            0 => [ 16 ],
            1 => [ 15 ]
        ], $searcher->search("test"));

        $this->assertEquals([
            0 => [ 8, 11 ],
            1 => [ 3 ],
            4 => [ 37 ]
        ], $searcher->search("is"));

        $this->assertEmpty($searcher->search("car"));
    }

    public function testSearchFromUrl(): void
    {
        $searcher = new FileSearcher("https://www.dropbox.com/s/3wtor9hhses4hfv/dummyfile?dl=1");

        $this->assertEquals([
            0 => [ 16 ],
            1 => [ 15 ]
        ], $searcher->search("test"));
    }

    public function testSearchFailedValidation(): void
    {
        $this->expectException(LogicException::class);

        new FileSearcher(__DIR__ . "/assets/dummyfile3.jpg");
    }
}