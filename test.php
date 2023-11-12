<?php

use Buismaarten\Crawler\Crawler;
use Buismaarten\Crawler\Discoverer;
use Buismaarten\Crawler\Filter;

require_once __DIR__.'/vendor/autoload.php';


$crawler = new Crawler;
$crawler->addDiscoverer(new Discoverer\CssSelectorDiscoverer('a[href]', 'href'));
$crawler->addFilter(new Filter\AllowedSchemesFilter(['http', 'https']));

foreach ($crawler->crawl('https://laravel.com/docs') as $url) {
    echo $url."\n";
}
