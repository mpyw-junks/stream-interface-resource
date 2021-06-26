<?php

namespace Mpyw\StreamInterfaceResource\Tests;

use Mpyw\StreamInterfaceResource\StreamInterfaceResource;
use PHPUnit\Framework\Error\Error;
use PHPUnit\Framework\TestCase;

class StreamFunctionsTest extends TestCase
{
    public function test_stream_get_contents(): void
    {
        $fp = StreamInterfaceResource::open("abc\ndef\n");

        $this->assertSame("abc\ndef\n", stream_get_contents($fp));
    }

    /**
     * Not supported
     */
    public function test_stream_copy_to_stream(): void
    {
        $src = StreamInterfaceResource::open("abc\ndef\n");
        $dst = StreamInterfaceResource::open('');

        $this->assertSame(8, stream_copy_to_stream($src, $dst));
    }

    /**
     * Not supported
     */
    public function test_stream_select(): void
    {
        $this->expectException(Error::class);

        $fp = StreamInterfaceResource::open("abc\ndef\n");

        $read = [$fp];
        $write = $except = null;

        stream_select($read, $write, $except, 1.0);
    }

    public function test_fclose(): void
    {
        $fp = StreamInterfaceResource::open("abc\ndef\n");

        $this->assertTrue(fclose($fp));
    }

    public function test_feof(): void
    {
        $fp = StreamInterfaceResource::open("abc\ndef\n");

        $this->assertFalse(feof($fp));
        stream_get_contents($fp);
        $this->assertTrue(feof($fp));
    }

    /**
     * Not supported
     */
    public function test_fflush(): void
    {
        $fp = StreamInterfaceResource::open("abc\ndef\n");

        $this->assertFalse(fflush($fp));
    }

    public function test_fgets(): void
    {
        $fp = StreamInterfaceResource::open("abc\ndef\n");

        $this->assertSame("abc\n", fgets($fp));
        $this->assertSame("def\n", fgets($fp));
        $this->assertFalse(fgets($fp));
    }

    /**
     * Not supported
     */
    public function test_flock(): void
    {
        $this->expectException(Error::class);

        $fp = StreamInterfaceResource::open("abc\ndef\n");

        flock($fp, LOCK_SH);
    }

    public function test_fstat(): void
    {
        $fp = StreamInterfaceResource::open("abc\ndef\n");

        $this->assertSame([
            0 => 0,
            1 => 0,
            2 => 0,
            3 => 0,
            4 => 0,
            5 => 0,
            6 => 0,
            7 => 8,
            8 => 0,
            9 => 0,
            10 => 0,
            11 => 0,
            12 => 0,
            'dev' => 0,
            'ino' => 0,
            'mode' => 0,
            'nlink' => 0,
            'uid' => 0,
            'gid' => 0,
            'rdev' => 0,
            'size' => 8,
            'atime' => 0,
            'mtime' => 0,
            'ctime' => 0,
            'blksize' => 0,
            'blocks' => 0,
        ], fstat($fp));
    }

    public function test_ftell(): void
    {
        $fp = StreamInterfaceResource::open("abc\ndef\n");

        $this->assertSame(0, ftell($fp));
    }

    /**
     * Not supported
     */
    public function test_ftruncate(): void
    {
        $this->expectException(Error::class);

        $fp = StreamInterfaceResource::open("abc\ndef\n");

        ftruncate($fp, 0);
    }

    public function test_fwrite(): void
    {
        $fp = StreamInterfaceResource::open("abc\ndef\n");

        fseek($fp, 0, SEEK_END);
        fwrite($fp, "ghi\n");
        rewind($fp);
        $this->assertSame("abc\ndef\nghi\n", stream_get_contents($fp));
    }
}
