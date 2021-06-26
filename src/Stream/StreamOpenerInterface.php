<?php

namespace Mpyw\StreamInterfaceResource\Stream;

use Psr\Http\Message\StreamInterface;

interface StreamOpenerInterface
{
    /**
     * @return resource
     */
    public function open(StreamInterface $stream);
}
