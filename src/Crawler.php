<?php

namespace Buismaarten\Crawler;

use Buismaarten\Crawler\Discoverers\AbstractDiscoverer;
use League\Uri\Contracts\UriInterface;
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

    public function getDomCrawler(): DomCrawler
    {
        return $this->domCrawler;
    }

    /** @return string[] */
    public function getUrls(AbstractDiscoverer $discoverer): array
    {
        $discoveredUrls = $this->getDiscoveredUrls($discoverer);
        $urls = [];

        foreach ($discoveredUrls as $discoveredUrl) {
            $urls[] = $discoveredUrl->toString();
        }

        $urls = array_unique($urls);
        $urls = array_values($urls);

        return $urls;
    }

    /** @return string[] */
    public function getHosts(AbstractDiscoverer $discoverer): array
    {
        $discoveredUrls = $this->getDiscoveredUrls($discoverer);
        $hosts = [];

        // @todo
        foreach ($discoveredUrls as $discoveredUrl) {
            $host = $discoveredUrl->getHost();

            if ($host !== null) {
                $hosts[] = $host;
            }
        }

        $hosts = array_unique($hosts);
        $hosts = array_values($hosts);

        return $hosts;
    }

    /** @return UriInterface[] */
    private function getDiscoveredUrls(AbstractDiscoverer $discoverer): iterable
    {
        $discoveredUrls = $discoverer->discover($this->getDomCrawler());

        foreach ($discoveredUrls as $discoveredUrl) {
            $url = Utils::normalizeUrl($discoveredUrl, $this->baseUrl);

            if ($url instanceof UriInterface && Utils::isValidUrl($url)) {
                yield $url;
            }
        }
    }
}
