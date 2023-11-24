<?php

namespace Buismaarten\Crawler;

use Buismaarten\Crawler\Discoverers\AbstractDiscoverer;
use League\Uri\Contracts\UriInterface;
use Symfony\Component\DomCrawler;

final class Crawler
{
    private readonly DomCrawler\Crawler $crawler;
    private readonly ?string $baseUrl;

    public function __construct(string $html, ?string $baseUrl = null)
    {
        $this->crawler = new DomCrawler\Crawler($html, uri: $baseUrl);
        $this->baseUrl = $baseUrl;
    }

    public function getCrawler(): DomCrawler\Crawler
    {
        return $this->crawler;
    }

    /** @return string[] */
    public function getUrls(AbstractDiscoverer $discoverer): array
    {
        // @todo
        $urls = array_map(fn (UriInterface $url) => $url->toString(), $this->getDiscoveredUrls($discoverer));
        $urls = array_filter($urls);
        $urls = array_unique($urls);
        $urls = array_values($urls);

        return $urls;
    }

    /** @return string[] */
    public function getDomains(AbstractDiscoverer $discoverer): array
    {
        // @todo
        $urls = array_map(fn (UriInterface $url) => $url->getHost(), $this->getDiscoveredUrls($discoverer));
        $urls = array_filter($urls);
        $urls = array_unique($urls);
        $urls = array_values($urls);

        return $urls;
    }

    /** @return UriInterface[] */
    private function getDiscoveredUrls(AbstractDiscoverer $discoverer): array
    {
        $discoveredUrls = $discoverer->discover($this->getCrawler());
        $urls = [];

        foreach ($discoveredUrls as $discoveredUrl) {
            $url = Utils::normalizeUrl($discoveredUrl, $this->baseUrl);

            if ($url !== null && Utils::isValidUrl($url)) {
                $urls[] = $url;
            }
        }

        return $urls;
    }
}
