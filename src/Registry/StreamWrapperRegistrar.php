<?php

namespace Mpyw\StreamInterfaceResource\Registry;

use Mpyw\StreamInterfaceResource\StreamWrapper\StreamWrapper;

abstract class StreamWrapperRegistrar
{
    public static function registerFor(StreamRegistrarInterface $registrar): void
    {
        $protocol = static::protocol($registrar);

        if (!\in_array($protocol, \stream_get_wrappers(), true)) {
            \stream_wrapper_register($protocol, StreamWrapper::class);
        }
    }

    /**
     * @codeCoverageIgnore
     */
    public static function unregisterFor(StreamRegistrarInterface $registrar): void
    {
        $protocol = static::protocol($registrar);

        if (\in_array($protocol, \stream_get_wrappers(), true)) {
            \stream_wrapper_unregister($protocol);
        }
    }

    public static function protocol(StreamRegistrarInterface $registrar): string
    {
        return \sha1(\spl_object_hash($registrar));
    }
}
