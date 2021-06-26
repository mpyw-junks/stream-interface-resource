<?php

namespace Mpyw\StreamInterfaceResource\Registry;

use Psr\Http\Message\StreamInterface;

interface PathGeneratorInterface
{
    public function generatePathFor(StreamInterface $stream): string;
}
