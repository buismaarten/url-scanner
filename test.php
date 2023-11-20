<?php

use Buismaarten\Crawler\Discoverers\AbstractDiscoverer;
use Buismaarten\Crawler\Discoverers\CssSelectorDiscoverer;
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
        $urls = $discoverer->discover($this->crawler);

        foreach ($urls as &$url) {
            $url = Uri::fromBaseUri($url, $this->baseUrl)->toString();

            // @todo
            if (! str_starts_with($url, 'http')) {
                $url = null;
            }
        }

        // @todo
        $urls = array_filter($urls);
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
