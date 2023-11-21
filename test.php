<?php

use Buismaarten\Crawler\Discoverers\AbstractDiscoverer;
use Buismaarten\Crawler\Discoverers\CssSelectorDiscoverer;
use League\Uri\Contracts\UriInterface;
use League\Uri\Uri;
use Symfony\Component\DomCrawler\Crawler;

require_once __DIR__.'/vendor/autoload.php';


class TestCrawler
{
    private Crawler $crawler;
    private ?string $baseUrl;

    public function __construct(string $html, ?string $baseUrl = null)
    {
        $this->crawler = new Crawler($html);
        $this->baseUrl = $baseUrl;
    }

    public function crawl(AbstractDiscoverer $discoverer): array
    {
        $discoveredUrls = $discoverer->discover($this->crawler);
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


$baseUrl = 'https://letsbuildit.nl';
$html = file_get_contents($baseUrl);
$crawler = new TestCrawler($html, $baseUrl);

print_r($crawler->crawl(new CssSelectorDiscoverer('a[href]', 'href')));
exit;
