<?php

namespace Buismaarten\Crawler;

use Buismaarten\Crawler\Discoverers\AbstractDiscoverer;
use League\Uri\Contracts\UriInterface;
use League\Uri\Exceptions\SyntaxError;
use League\Uri\Uri;
use Symfony\Component\DomCrawler\Crawler as DomCrawler;

final class Crawler
{
    private readonly DomCrawler $domCrawler;
    private readonly ?string $baseUrl;

    public function __construct(string $html, ?string $baseUrl = null)
    {
        $this->domCrawler = new DomCrawler($html, uri: $baseUrl);
        $this->baseUrl = $baseUrl;
    }

    public function crawl(AbstractDiscoverer $discoverer): array
    {
        $discoveredUrls = $discoverer->discover($this->domCrawler);
        $urls = [];

        foreach ($discoveredUrls as $discoveredUrl) {
            $url = self::normalizeUrl($discoveredUrl, $this->baseUrl);

            // @todo
            if ($url !== null && str_starts_with($url, 'http')) {
                $urls[] = $url;
            }
        }

        $urls = array_map(fn (UriInterface $url) => $url->toString(), $urls);
        $urls = array_unique($urls);
        $urls = array_values($urls);

        return $urls;
    }

    private static function normalizeUrl(string $url, string $baseUrl): ?UriInterface
    {
        try {
            $components = Uri::fromBaseUri($url, $baseUrl)->getComponents();
            $components['path'] = rtrim($components['path'], '/');
        } catch (SyntaxError) {
            return null;
        }

        return Uri::fromComponents([
            'scheme' => $components['scheme'],
            'host'   => $components['host'],
            'port'   => $components['port'],
            'path'   => $components['path'],
            'query'  => $components['query'],
        ]);
    }
}
