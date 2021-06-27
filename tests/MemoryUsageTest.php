<?php

namespace Mpyw\StreamInterfaceResource\Tests;

use Mpyw\StreamInterfaceResource\StreamInterfaceResource;
use PHPUnit\Framework\TestCase;

class MemoryUsageTest extends TestCase
{
    public function testDump(): void
    {
        if (getenv('SCRUTINIZER')) {
            $this->markTestSkipped('Skip ' . __FUNCTION__ . ' because the environment unexpectedly causes memory leaks.');
        }

        $beforeUsages = array_fill(0, 1000, 0);
        $afterUsages = array_fill(0, 1000, 0);

        for ($i = 0; $i < 1000; ++$i) {
            $beforeUsages[$i] = memory_get_usage();
            static::performOneCycle();
            $afterUsages[$i] = memory_get_usage();
            gc_collect_cycles();
        }

        $this->assertCount(1, array_unique(array_slice($beforeUsages, 10)));
        $this->assertCount(1, array_unique(array_slice($afterUsages, 10)));
    }

    public static function performOneCycle(): void
    {
        /* @noinspection PhpUnhandledExceptionInspection */
        StreamInterfaceResource::open(random_bytes(20));
    }
}
