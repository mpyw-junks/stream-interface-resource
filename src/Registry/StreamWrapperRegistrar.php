<?php

namespace Mpyw\StreamInterfaceResource\Registry;

use Mpyw\StreamInterfaceResource\StreamWrapper\StreamWrapper;

abstract class StreamWrapperRegistrar
{
    public static function registerFor(StreamRegistrarInterface $registrar)
    {
        $protocol = static::protocol($registrar);

        if (!\in_array($protocol, \stream_get_wrappers(), true)) {
            \stream_wrapper_register($protocol, StreamWrapper::class);
        }
    }

    public static function unregisterFor(StreamRegistrarInterface $registrar)
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
