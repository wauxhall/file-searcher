<?php

use PHPUnit\Framework\TestCase;
use Wauxhall\FileSearcher\HashsumChecker;

class HashsumCheckerTest extends TestCase
{
    public function testCheck()
    {
        $checker = new HashsumChecker(__DIR__ . "/assets/dummyfile", true);

        $this->assertTrue($checker->check('3e5c3776fe2c8aff78d6f5f9d30c71a2'));
    }

    public function testCheckFail()
    {
        $checker = new HashsumChecker(__DIR__ . "/assets/dummyfile", true);

        $this->assertFalse($checker->check('6e5c3776fe2c8aff78d6f5f9d30c71a2'));
    }
}