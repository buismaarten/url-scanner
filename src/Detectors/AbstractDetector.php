<?php

declare(strict_types=1);

namespace Buismaarten\UrlScanner\Detectors;

abstract class AbstractDetector
{
    private string $url;

    public function __construct(string $url)
    {
        $this->url = $url;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    /** @return iterable<string> */
    abstract public function detect(): iterable;
}
