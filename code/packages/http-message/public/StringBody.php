<?php

namespace Bauhaus\Http\Message;

use Psr\Http\Message\StreamInterface as PsrStream;

final readonly class StringBody implements PsrStream
{
    private function __construct(
        private string $value,
    ) {
    }

    public static function empty(): self
    {
        return new self('');
    }

    public static function with(string $str): self
    {
        return new self($str);
    }

    public function toString(): string
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->toString();
    }

    public function close(): void
    {
    }

    public function detach(): void
    {
    }

    public function getSize(): int
    {
    }

    public function tell()
    {
    }

    public function eof()
    {
    }

    public function isSeekable()
    {
    }

    public function seek($offset, $whence = SEEK_SET)
    {
    }

    public function rewind()
    {
    }

    public function isWritable()
    {
    }

    public function write($string)
    {
    }

    public function isReadable()
    {
    }

    public function read($length)
    {
    }

    public function getContents()
    {
    }

    public function getMetadata($key = null)
    {
    }
}
