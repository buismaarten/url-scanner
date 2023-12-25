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

            if ($host !== null && Utils::validateHost($host)) {
                $hosts[] = Utils::normalizeHost($host);
            }
        }

        return self::normalizeArray($hosts);
    }

    /** @return string[] */
    public function getUrls(): array
    {
        $urls = [];

        foreach ($this->urls as $url) {
            $urls[] = $url->toString();
        }

        return self::normalizeArray($urls);
    }

    /**
     * @param string[] $array
     * @return string[]
     */
    private static function normalizeArray(array $array): array
    {
        $array = array_unique($array);
        $array = array_values($array);

        return $array;
    }
}
