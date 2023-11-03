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

require_once __DIR__.'/src/DiscovererCollection.php';
require_once __DIR__.'/src/Resource.php';



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
        $resource = $this->getDownloader()->download($url);
        $results = $this->getDiscovererCollection()->discover($resource);

        return $results;
    }
}


$spider = new Spider;
$spider->getDiscovererCollection()->addDiscoverer(new CssSelectorDiscoverer('a[href]', 'href'));
$spider->getDiscovererCollection()->addFilter(new AllowedSchemeFilter(['http', 'https']));

print_r($spider->crawl('https://laravel.com/docs'));
exit;
