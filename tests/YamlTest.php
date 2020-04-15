<?php

use PHPUnit\Framework\TestCase;
use Wauxhall\FileSearcher\Core\Config\Yaml;

class YamlTest extends TestCase
{
    protected $yaml_config;

    public function setUp(): void
    {
        $this->yaml_config = new Yaml();
    }

    public function testLoad()
    {
        $data = $this->yaml_config->load("common");

        $this->assertIsArray($data);
        $this->assertNotEmpty($data);
    }

    public function testLoadNotExistingConfig()
    {
        $this->expectException(RuntimeException::class);
        $this->yaml_config->load("someconfig");
    }
}