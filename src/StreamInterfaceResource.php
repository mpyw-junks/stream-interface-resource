<?php

namespace Mpyw\StreamInterfaceResource;

use GuzzleHttp\Psr7\Utils;
use Mpyw\StreamInterfaceResource\Registry\StreamRegistrar;
use Mpyw\StreamInterfaceResource\Stream\StreamOpener;
use Psr\Http\Message\StreamInterface;

abstract class StreamInterfaceResource
{
    /**
     * @param  null|bool|callable|float|int|\Iterator|resource|StreamInterface|string $resource
     * @return resource
     */
    public static function open($resource = '')
    {
        $stream = Utils::streamFor($resource);

        return (new StreamOpener(StreamRegistrar::getInstance()))->open($stream);
    }
}
