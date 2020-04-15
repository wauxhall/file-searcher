<?php

use PHPUnit\Framework\TestCase;
use function Wauxhall\FileSearcher\Helpers\isPathAnUrl;
use function Wauxhall\FileSearcher\Helpers\resolveDotSeparatedPath;
use function Wauxhall\FileSearcher\Helpers\storage_path;
use function Wauxhall\FileSearcher\Helpers\striposAll;

class HelpersTest extends TestCase
{
    public function testStoragePath()
    {
        $path = storage_path();

        $this->assertDirectoryExists($path);
        $this->assertDirectoryIsWritable($path);
    }

    public function testStriposAll()
    {
        $input = "Sasha went on the highway and sucked a bagel. The way was long. The sun stayed high.";

        $result = striposAll($input, "way");

        $this->assertEquals([22, 50], $result);

        $result = striposAll($input, "High");

        $this->assertEquals([18, 79], $result);

        $result = striposAll($input, "123");

        $this->assertEmpty($result);
    }

    public function testIsPathAnUrl()
    {
        $path = "https://vk.com";

        $this->assertTrue(isPathAnUrl($path));

        $path = "http://a.com:8080";

        $this->assertTrue(isPathAnUrl($path));

        $path = "https://ftp.vk.com:a22";

        $this->assertFalse(isPathAnUrl($path));

        $path = "ftp://ftp.vk.com:22";

        $this->assertFalse(isPathAnUrl($path));

        $path = "http:/wtf.com";

        $this->assertFalse(isPathAnUrl($path));

        $path = "wtf.com"; // Protocol is required

        $this->assertFalse(isPathAnUrl($path));

        $path = "C:\Users";

        $this->assertFalse(isPathAnUrl($path));
    }

    public function testResolveDotSeparatedPath()
    {
        $array = [
            'cars' => [
                'vauxhall' => [
                    'speedster' => 4,
                    'gto' => 5
                ],
                'honda' => [
                    'civic' => 1,
                    'prelude' => 2,
                    'accord' => 3
                ]
            ],
            'ships' => false
        ];

        $path = 'cars.vauxhall.speedster';
        $result = resolveDotSeparatedPath($array, $path);
        $this->assertEquals(4, $result);

        $path = 'cars.honda';
        $result = resolveDotSeparatedPath($array, $path);
        $this->assertEquals([
            'civic' => 1,
            'prelude' => 2,
            'accord' => 3
        ], $result);

        $path = 'ships';
        $result = resolveDotSeparatedPath($array, $path);
        $this->assertFalse($result);

        $path = 'ships.boats';
        $result = resolveDotSeparatedPath($array, $path);
        $this->assertEmpty($result);

        $path = 'planes';
        $result = resolveDotSeparatedPath($array, $path);
        $this->assertEmpty($result);

        $path = '';
        $result = resolveDotSeparatedPath($array, $path);
        $this->assertEmpty($result);
    }
}