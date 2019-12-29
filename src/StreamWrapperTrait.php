<?php

namespace Mpyw\StreamInterfaceResource;

use Psr\Http\Message\StreamInterface;

trait StreamWrapperTrait
{
    abstract protected function stream(): StreamInterface;

    public function stream_close()
    {
        $this->stream()->close();
    }

    public function stream_eof()
    {
        return $this->stream()->eof();
    }

    public function stream_open($path, $mode, $options, &$opened_path)
    {
        return true;
    }

    public function stream_read($count)
    {
        return $this->stream()->read($count);
    }

    public function stream_seek($offset, $whence = SEEK_SET)
    {
        $this->stream()->seek($offset, $whence);
        return true;
    }

    public function stream_stat()
    {
        return [
            'size' => $this->stream()->getSize(),
        ];
    }

    public function stream_tell()
    {
        return $this->stream()->tell();
    }

    public function stream_write($data)
    {
        return $this->stream()->write($data);
    }
}
