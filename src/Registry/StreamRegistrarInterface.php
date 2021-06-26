<?php

namespace Mpyw\StreamInterfaceResource\Registry;

use Psr\Http\Message\StreamInterface;

interface StreamRegistrarInterface
{
    public function register(StreamInterface $stream): void;

    public function remove(StreamInterface $stream): void;

    public function pathFor(StreamInterface $stream): string;

    public function streamFor(string $path): StreamInterface;
}
