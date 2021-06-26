<?php

namespace Mpyw\StreamInterfaceResource\Registry;

use Mpyw\StreamInterfaceResource\Unserializable;
use Psr\Http\Message\StreamInterface;

class StreamRegistrar implements StreamRegistrarInterface
{
    use Unserializable;

    /**
     * @var static
     */
    protected static $instance;

    /**
     * @var PathGeneratorInterface
     */
    protected $pathGenerator;

    /**
     * @var \SplObjectStorage|string[]
     */
    protected $streamToPath;

    /**
     * @var StreamInterface[]
     */
    protected $pathToStream = [];

    /**
     * @return static
     */
    public static function getInstance()
    {
        if (!static::$instance) {
            StreamWrapperRegistrar::registerFor(static::$instance = new static());
        }

        return static::$instance;
    }

    public function __construct(?PathGeneratorInterface $pathGenerator = null)
    {
        $this->pathGenerator = $pathGenerator ?? new PathGenerator($this);
        $this->streamToPath = new \SplObjectStorage();
    }

    public function register(StreamInterface $stream): void
    {
        if (!$this->streamToPath->contains($stream)) {
            $path = $this->pathGenerator->generatePathFor($stream);

            $this->streamToPath->attach($stream, $path);
            $this->pathToStream[$path] = $stream;
        }
    }

    public function remove(StreamInterface $stream): void
    {
        if ($this->streamToPath->contains($stream)) {
            $path = $this->pathGenerator->generatePathFor($stream);

            $this->streamToPath->detach($stream);
            unset($this->pathToStream[$path]);
        }
    }

    public function pathFor(StreamInterface $stream): string
    {
        if (!$this->streamToPath->contains($stream)) {
            throw new \OutOfBoundsException();
        }

        return $this->streamToPath[$stream];
    }

    public function streamFor(string $path): StreamInterface
    {
        if (!isset($this->pathToStream[$path])) {
            throw new \OutOfBoundsException();
        }

        return $this->pathToStream[$path];
    }

    public function __debugInfo(): array
    {
        $map = [];

        foreach ($this->pathToStream as $path => $stream) {
            $key = \sprintf('object(%s)#%s', \get_class($stream), \spl_object_id($stream));
            $map[$key] = $this->pathGenerator->generatePathFor($stream);
        }

        return [
            '*map*' => $map,
        ];
    }
}
