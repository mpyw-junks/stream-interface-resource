# Stream Interface Resource [![Build Status](https://github.com/mpyw/stream-interface-resource/actions/workflows/ci.yml/badge.svg?branch=master)](https://github.com/mpyw/stream-interface-resource/actions) [![Coverage Status](https://coveralls.io/repos/github/mpyw/stream-interface-resource/badge.svg?branch=master)](https://coveralls.io/github/mpyw/stream-interface-resource?branch=master) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/mpyw/stream-interface-resource/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/mpyw/stream-interface-resource/?branch=master)

Create resource stream from PSR-7 StreamInterface implementation.

## Requirements

- PHP: `^7.1 || ^8.0`

## Installing

```bash
composer require mpyw/stream-interface-resource
```

## Usage

### From `StreamInterface`

```php
<?php

use Mpyw\StreamInterfaceResource\StreamInterfaceResource;
use function GuzzleHttp\Psr7\stream_for;

$fp = StreamInterfaceResource::open(stream_for("a\nbcd\n"));

var_dump(fgets($fp)); // "a\n"
var_dump(feof($fp)); // false

var_dump(fgets($fp)); // "bcd\n"
var_dump(feof($fp)); // false (PHP ~7.1), true (PHP ^7.2)

var_dump(fgets($fp)); // false
var_dump(feof($fp)); // true
```


### From String

```php
StreamInterfaceResource::open("a\nbcd\n")
```

### From Iterator

```php
StreamInterfaceResource::open(new ArrayIterator(["a\n", "b\n", "c\n"]))
```

### From Generator

```php
StreamInterfaceResource::open((function () {
    for ($i = 0; true; ++$i) {
        yield "$i\n";
    }
})())
```

## Supported Operations

- `fclose`
- `feof`
- `fgets`
- `fread`
- `fseek`
- `ftell`
- `fwrite`
- `rewind`
- `stream_get_contents`
- `stream_copy_to_stream`
