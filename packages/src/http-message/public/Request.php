<?php

namespace Bauhaus\Http\Message;

use Bauhaus\Http\Message\Request\Method;
use Psr\Http\Message\RequestInterface as PsrRequest;
use Psr\Http\Message\StreamInterface as PsrStream;
use Psr\Http\Message\UriInterface as PsrUri;

final class Request implements PsrRequest
{
    public function __construct(
        private readonly Protocol $protocol,
        private readonly Method $method,
        private readonly Headers $headers,
        private readonly Body $body,
    ) {
    }

    public function toString(): string
    {
        return <<<STR
            {$this->protocol->toString()} {$this->method->toString()}
            {$this->headers->toString()}

            {$this->body->toString()}
            STR;
    }

    /** {@inheritdoc} */
    public function getProtocolVersion(): string
    {
        return $this->protocol->versionToString();
    }

    /** {@inheritdoc} */
    public function getMethod(): string
    {
        return $this->method->toString();
    }

    /** {@inheritdoc} */
    public function getUri(): PsrUri
    {
    }

    /** {@inheritdoc} */
    public function getRequestTarget(): string
    {
    }

    /** {@inheritdoc} */
    public function hasHeader($name): bool
    {
        return $this->headers->has($name);
    }

    /** {@inheritdoc} */
    public function getHeader($name): array
    {
        return $this->headers->find($name)->values();
    }

    /** {@inheritdoc} */
    public function getHeaderLine($name): string
    {
        return $this->headers->find($name)->valuesToString();
    }

    /** {@inheritdoc} */
    public function getHeaders(): array
    {
        return $this->headers->toArray();
    }

    /** {@inheritdoc} */
    public function getBody(): PsrStream
    {
        return $this->body;
    }

    /** {@inheritdoc} */
    public function withProtocolVersion($version): PsrRequest
    {
        return $this->clonedWith(protocol: Protocol::fromString($version));
    }

    /** {@inheritdoc} */
    public function withMethod($method): PsrRequest
    {
        return $this->clonedWith(method: Method::fromString($method));
    }

    /** {@inheritdoc} */
    public function withUri(PsrUri $uri, $preserveHost = false): PsrRequest
    {
    }

    /** {@inheritdoc} */
    public function withRequestTarget($requestTarget): PsrRequest
    {
    }

    /** {@inheritdoc} */
    public function withHeader($name, $value): PsrRequest
    {
        $values = is_array($value) ? $value : [$value];
        $headers = $this->headers->overwrittenWith($name, ...$values);

        return $this->clonedWith(headers: $headers);
    }

    /** {@inheritdoc} */
    public function withAddedHeader($name, $value): PsrRequest
    {
        $values = is_array($value) ? $value : [$value];
        $headers = $this->headers->appendedWith($name, ...$values);

        return $this->clonedWith(headers: $headers);
    }

    /** {@inheritdoc} */
    public function withoutHeader($name): PsrRequest
    {
        return $this->clonedWith(headers: $this->headers->without($name));
    }

    /** {@inheritdoc} */
    public function withBody(PsrStream $body): PsrRequest
    {
        return $this->clonedWith(body: $body);
    }

    private function clonedWith(
        Protocol $protocol = null,
        Method $method = null,
        Headers $headers = null,
        Body $body = null,
    ): self {
        return new self(
            $protocol ?? $this->protocol,
            $method ?? $this->method,
            $headers ?? $this->headers,
            $body ?? $this->body,
        );
    }
}
