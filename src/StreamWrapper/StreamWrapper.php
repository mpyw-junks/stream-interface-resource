<?php

namespace Mpyw\StreamInterfaceResource\StreamWrapper;

use Mpyw\StreamInterfaceResource\Registry\StreamRegistrar;
use Mpyw\StreamInterfaceResource\Registry\StreamRegistrarInterface;
use Mpyw\StreamInterfaceResource\Unserializable;
use Psr\Http\Message\StreamInterface;

class StreamWrapper implements StreamWrapperInterface
{
    use Unserializable;

    /**
     * @var StreamInterface
     */
    protected $stream;

    /**
     * @var null|StreamRegistrar
     */
    public static $defaultRegistrar = null;

    /**
     * @var StreamRegistrarInterface
     */
    protected $registrar;

    public function __construct(?StreamRegistrarInterface $registrar = null)
    {
        $this->registrar = $registrar ?? static::$defaultRegistrar ?? StreamRegistrar::getInstance();
    }

    public function __destruct()
    {
        $this->registrar->remove($this->stream);
    }

    public function stream_close(): void
    {
        $this->stream->close();
    }

    public function stream_eof(): bool
    {
        return $this->stream->eof();
    }

    public function stream_open(string $path, string $mode, int $options, &$opened_path): bool
    {
        $this->stream = $this->registrar->streamFor($path);
        return true;
    }

    public function stream_read(int $count): string
    {
        return $this->stream->read($count);
    }

    public function stream_seek(int $offset, int $whence = SEEK_SET): bool
    {
        $this->stream->seek($offset, $whence);
        return true;
    }

    public function stream_stat(): array
    {
        return [
            'size' => $this->stream->getSize(),
        ];
    }

    public function stream_tell(): int
    {
        return $this->stream->tell();
    }

    public function stream_write(string $data): int
    {
        return $this->stream->write($data);
    }
}
