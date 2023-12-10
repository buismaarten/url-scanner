<?php

declare(strict_types=1);

namespace Buismaarten\UrlScanner;

use League\Uri\Contracts\UriInterface;

final class UrlScannerResult
{
    /** @var UriInterface[] $urls */
    private array $urls = [];

    /** @param UriInterface[] $urls */
    public function __construct(array $urls)
    {
        $this->urls = $urls;
    }

    /** @return string[] */
    public function getHosts(): array
    {
        $hosts = [];

        foreach ($this->urls as $url) {
            $host = $url->getHost();

            if ($host !== null) {
                $hosts[] = Utils::normalizeHost($host);
            }
        }

        // @todo
        $hosts = array_unique($hosts);
        $hosts = array_values($hosts);

        return $hosts;
    }

    /** @return string[] */
    public function getUrls(): array
    {
        $urls = [];

        foreach ($this->urls as $url) {
            $urls[] = $url->toString();
        }

        // @todo
        $urls = array_unique($urls);
        $urls = array_values($urls);

        return $urls;
    }
}
