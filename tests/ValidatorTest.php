<?php

use PHPUnit\Framework\TestCase;
use Wauxhall\FileSearcher\Core\Config\Yaml;
use Wauxhall\FileSearcher\Validation\Validator;

class ValidatorTest extends TestCase
{
    private $validator;

    protected function setUp(): void
    {
        $this->validator = new Validator();
        $config = new Yaml();
        $config->load('common');
    }

    public function testDoesFileExist()
    {
        $exp = $this->validator->doesFileExist(__DIR__ . "/assets/dummyfile");
        $this->assertTrue($exp);
    }

    public function testGetMimeType()
    {
        $mime = $this->validator->getMimeType(__DIR__ . "/assets/dummyfile");
        $this->assertEquals("text/plain", $mime);
    }

    public function testGetSize()
    {
        $size = $this->validator->getSize(__DIR__ . "/assets/dummyfile");
        $this->assertEquals(171, $size);
    }

    public function testValidate()
    {
        $exp = $this->validator->validate(__DIR__ . "/assets/dummyfile");
        $this->assertTrue($exp);
    }

    public function testValidateFailureFileNotFound()
    {
        $this->expectException(LogicException::class);
        $this->expectExceptionCode(404);
        $this->validator->validate(__DIR__ . "/assets/dummyfile1");
    }

    public function testValidateFailureNotAllowedMimeType()
    {
        $this->expectException(LogicException::class);
        $this->expectExceptionCode(4221);
        $this->validator->validate(__DIR__ . "/assets/dummyfile2.html");
    }

    public function testValidateFailureInvalidSize()
    {
        $this->expectException(LogicException::class);
        $this->expectExceptionCode(4222);
        $this->validator->validate(__DIR__ . "/assets/dummyfile3.jpg");
    }
}