<?php

namespace Mpyw\StreamInterfaceResource\StreamWrapper;

interface StreamWrapperInterface
{
    public function stream_close(): void;

    public function stream_eof(): bool;

    public function stream_open(string $path, string $mode, int $options, &$opened_path): bool;

    public function stream_read(int $count): string;

    public function stream_seek(int $offset, int $whence = SEEK_SET): bool;

    public function stream_stat(): array;

    public function stream_tell(): int;

    public function stream_write(string $data): int;
}
