<?php

namespace Mpyw\StreamInterfaceResource;

trait Unserializable
{
    /**
     * @codeCoverageIgnore
     */
    public function __sleep()
    {
        throw new \BadMethodCallException('You cannot serialize ' . static::class . ' instance.');
    }
}
