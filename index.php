<?php

require_once __DIR__.'/vendor/autoload.php';

require_once __DIR__.'/src/Downloaders/AbstractDownloader.php';
require_once __DIR__.'/src/Downloaders/NativeDownloader.php';

require_once __DIR__.'/src/Discoverers/AbstractDiscoverer.php';
require_once __DIR__.'/src/Discoverers/CssSelectorDiscoverer.php';
require_once __DIR__.'/src/Discoverers/XPathSelectorDiscoverer.php';

require_once __DIR__.'/src/Filters/AbstractFilter.php';
require_once __DIR__.'/src/Filters/AllowedHostsFilter.php';
require_once __DIR__.'/src/Filters/AllowedSchemeFilter.php';


class DiscovererCollection
{
    private array $discoverers = [];
    private array $filters = [];

    public function addDiscoverer(AbstractDiscoverer $discoverer): void
    {
        $this->discoverers[] = $discoverer;
    }

    public function addFilter(AbstractFilter $filter): void
    {
        $this->filters[] = $filter;
    }

    public function discover(string $content): array
    {
        $results = [];

        foreach ($this->discoverers as $discoverer) {
            $results = array_merge($results, $discoverer->discover($content));
        }

        return $results;
    }
}

class Spider
{
    private AbstractDownloader $downloader;
    private DiscovererCollection $discovererCollection;

    public function __construct(AbstractDownloader $downloader = null, DiscovererCollection $discovererCollection = null)
    {
        $this->downloader = ($downloader ?? new NativeDownloader);
        $this->discovererCollection = ($discovererCollection ?? new DiscovererCollection);
    }

    public function getDownloader(): AbstractDownloader
    {
        return $this->downloader;
    }

    public function getDiscovererCollection(): DiscovererCollection
    {
        return $this->discovererCollection;
    }

    public function crawl(string $url): array
    {
        $content = $this->getDownloader()->download($url);
        $results = $this->getDiscovererCollection()->discover($content);

        return $results;
    }
}



$spider = new Spider;
$spider->getDiscovererCollection()->addDiscoverer(new CssSelectorDiscoverer('a[href]', 'href'));
$spider->getDiscovererCollection()->addFilter(new AllowedSchemeFilter(['http', 'https']));

print_r($spider->crawl('https://laravel.com'));
