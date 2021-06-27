<?php

namespace Mpyw\StreamInterfaceResource\Tests;

use Mpyw\StreamInterfaceResource\Registry\StreamRegistrar;
use Mpyw\StreamInterfaceResource\StreamInterfaceResource;
use PHPUnit\Framework\TestCase;

class VarDumpTest extends TestCase
{
    public function testDump(): void
    {
        if (getenv('SCRUTINIZER') || \version_compare(PHP_VERSION, '7.2', '<')) {
            $this->markTestSkipped('Skip ' . __FUNCTION__ . ' because __debugInfo() does not work correctly in some environments.');
        }

        $fp = StreamInterfaceResource::open("a\nb\n");

        $needle = <<<EOD
  ["*map*"]=>
  array(1) {
    ["object(GuzzleHttp\Psr7\Stream)
EOD;
        $this->assertStringContainsString($needle, static::varDump(StreamRegistrar::getInstance()));

        unset($fp);
        $this->assertStringNotContainsString($needle, static::varDump(StreamRegistrar::getInstance()));
    }

    protected static function varDump($var)
    {
        ob_start();
        try {
            var_dump($var);
            return ob_get_contents();
        } finally {
            ob_end_clean();
        }
    }
}
