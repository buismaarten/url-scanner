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
        $urls = [];

        // @todo
        foreach ($discoveredUrls as $discoveredUrl) {
            $url = $discoveredUrl->getHost();

            if ($url !== null) {
                $urls[] = $url;
            }
        }

        $urls = array_unique($urls);
        $urls = array_values($urls);

        return $urls;
    }

    /** @return UriInterface[] */
    private function getDiscoveredUrls(AbstractDiscoverer $discoverer): iterable
    {
        $discoveredUrls = $discoverer->discover($this->getCrawler());

        foreach ($discoveredUrls as $discoveredUrl) {
            $url = Utils::normalizeUrl($discoveredUrl, $this->baseUrl);

            if ($url instanceof UriInterface && Utils::isValidUrl($url)) {
                yield $url;
            }
        }
    }
}
