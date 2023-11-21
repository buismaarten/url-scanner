<?php

namespace Buismaarten\Crawler;

use Buismaarten\Crawler\Discoverers\AbstractDiscoverer;
use League\Uri\Contracts\UriInterface;
use League\Uri\Uri;
use Symfony\Component\DomCrawler\Crawler as DomCrawler;

final class Crawler
{
    private DomCrawler $domCrawler;
    private ?string $baseUrl;

    public function __construct(string $html, ?string $baseUrl = null)
    {
        $this->domCrawler = new DomCrawler($html);
        $this->baseUrl = $baseUrl;
    }

    public function crawl(AbstractDiscoverer $discoverer): array
    {
        $discoveredUrls = $discoverer->discover($this->domCrawler);
        $urls = [];

        foreach ($discoveredUrls as $discoveredUrl) {
            $url = Uri::fromBaseUri($discoveredUrl, $this->baseUrl);

            // @todo
            if (str_starts_with($url, 'http')) {
                $urls[] = $url;
            }
        }

        $urls = array_map(fn (UriInterface $url) => $url->toString(), $urls);
        $urls = array_unique($urls);
        $urls = array_values($urls);

        return $urls;
    }
}
