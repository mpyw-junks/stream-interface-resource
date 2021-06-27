<?php

namespace Mpyw\StreamInterfaceResource\Tests;

use ArrayIterator;
use Mpyw\StreamInterfaceResource\StreamInterfaceResource;
use PHPUnit\Framework\TestCase;

class FeatureTest extends TestCase
{
    public function testString(): void
    {
        $fp = StreamInterfaceResource::open("a\nbcd\n");

        $this->assertSame("a\n", fgets($fp));
        $this->assertFalse(feof($fp));

        $this->assertSame("bcd\n", fgets($fp));
        version_compare(PHP_VERSION, '7.2', '>=')
            ? $this->assertTrue(feof($fp))
            : $this->assertFalse(feof($fp));

        $this->assertFalse(fgets($fp));
        $this->assertTrue(feof($fp));
    }

    public function testArray(): void
    {
        $fp = StreamInterfaceResource::open(new ArrayIterator(["a\nb", 'c', "d\n"]));

        $this->assertSame("a\n", fgets($fp));
        $this->assertFalse(feof($fp));

        $this->assertSame("bcd\n", fgets($fp));
        $this->assertTrue(feof($fp));

        $this->assertFalse(fgets($fp));
        $this->assertTrue(feof($fp));
    }

    public function testInfiniteArray(): void
    {
        $fp = StreamInterfaceResource::open((function () {
            while (true) {
                foreach (["a\nb", 'c', "d\n"] as $entry) {
                    yield $entry;
                }
            }
        })());

        $this->assertSame("a\n", fgets($fp));
        $this->assertFalse(feof($fp));

        $this->assertSame("bcd\n", fgets($fp));
        $this->assertFalse(feof($fp));

        $this->assertSame("a\n", fgets($fp));
        $this->assertFalse(feof($fp));

        $this->assertSame("bcd\n", fgets($fp));
        $this->assertFalse(feof($fp));
    }
}
