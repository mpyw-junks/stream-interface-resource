<?php

namespace Mpyw\StreamInterfaceResource\Registry;

use Psr\Http\Message\StreamInterface;

class PathGenerator implements PathGeneratorInterface
{
    /**
     * @var StreamRegistrarInterface
     */
    protected $registrar;

    public function __construct(StreamRegistrarInterface $registrar)
    {
        $this->registrar = $registrar;
    }

    public function generatePathFor(StreamInterface $stream): string
    {
        return \sprintf(
            '%s://%s',
            StreamWrapperRegistrar::protocol($this->registrar),
            \spl_object_hash($stream)
        );
    }
}
