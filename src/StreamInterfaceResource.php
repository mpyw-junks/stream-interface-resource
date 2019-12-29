<?php

namespace Mpyw\StreamInterfaceResource;

use ErrorException;
use function GuzzleHttp\Psr7\stream_for;
use Iterator;
use Psr\Http\Message\StreamInterface;

class StreamInterfaceResource
{
    /**
     * @param  null|bool|callable|float|int|Iterator|resource|StreamInterface|string $resource
     * @param  array                                                                 $options
     * @return resource
     */
    public static function open($resource = '', array $options = [])
    {
        $stream = stream_for($resource, $options);

        $wrapper = static::createStreamWrapper($stream);
        $class = get_class($wrapper);
        $protocol = sha1($class);

        set_error_handler(static function (int $code, string $message, string $file, int $line) use (&$error): bool {
            // @codeCoverageIgnoreStart
            $error = new ErrorException($message, $code, 1, $file, $line);
            return true;
            // @codeCoverageIgnoreEnd
        });
        stream_wrapper_register($protocol, $class);
        restore_error_handler();

        if ($error) {
            // @codeCoverageIgnoreStart
            throw $error;
            // @codeCoverageIgnoreEnd
        }

        set_error_handler(static function (int $code, string $message, string $file, int $line) use (&$error): bool {
            // @codeCoverageIgnoreStart
            $error = new ErrorException($message, $code, 1, $file, $line);
            return true;
            // @codeCoverageIgnoreEnd
        });
        $fp = fopen("$protocol://", 'r+b');
        stream_wrapper_unregister($protocol);
        restore_error_handler();

        if ($error) {
            // @codeCoverageIgnoreStart
            throw $error;
            // @codeCoverageIgnoreEnd
        }

        return $fp;
    }

    protected static function createStreamWrapper(StreamInterface $stream)
    {
        $wrapper = new class() {
            use StreamWrapperTrait;

            public static $stream;

            protected function stream(): StreamInterface
            {
                return self::$stream;
            }
        };

        $wrapper::$stream = $stream;

        return $wrapper;
    }
}
