<?php

namespace Mpyw\StreamInterfaceResource\Stream;

use Mpyw\StreamInterfaceResource\Registry\StreamRegistrarInterface;
use Mpyw\StreamInterfaceResource\Unserializable;
use Psr\Http\Message\StreamInterface;

class StreamOpener implements StreamOpenerInterface
{
    use Unserializable;

    /**
     * @var StreamRegistrarInterface
     */
    protected $registrar;

    public function __construct(StreamRegistrarInterface $registrar)
    {
        $this->registrar = $registrar;
    }

    /**
     * @return resource
     */
    public function open(StreamInterface $stream)
    {
        $this->registrar->register($stream);

        return \fopen($this->registrar->pathFor($stream), '');
    }
}
