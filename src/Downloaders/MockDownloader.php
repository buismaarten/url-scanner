<?php

declare(strict_types=1);

namespace Buismaarten\UrlScanner\Downloaders;

class MockDownloader extends AbstractDownloader
{
    /** @phpstan-ignore-next-line */
    private array $collection;

    /** @phpstan-ignore-next-line */
    public function __construct(array $collection)
    {
        $this->collection = $collection;
    }

    public function download(string $url): string
    {
        $body = ($this->collection[$url] ?? '');
        $body = substr($body, 0, $this->getLength());

        return $body;
    }
}
