<?php

declare(strict_types=1);

namespace Buismaarten\UrlScanner;

use League\Uri\Contracts\UriInterface;

final class UrlScannerResult
{
    /** @param UriInterface[] $urls */
    public function __construct(private array $urls)
    {
    }

    /** @return string[] */
    public function getHosts(): array
    {
        $hosts = [];

        // @todo: normalize hostname
        foreach ($this->urls as $url) {
            $host = $url->getHost();

            if ($host !== null) {
                $hosts[] = $host;
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
