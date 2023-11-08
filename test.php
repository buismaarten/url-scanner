<?php

use Buismaarten\Crawler\Crawler;
use Buismaarten\Crawler\Discoverers;
use Buismaarten\Crawler\Filters;

require_once __DIR__.'/vendor/autoload.php';


$crawler = new Crawler;
$crawler->addDiscoverer(new Discoverers\CssSelectorDiscoverer('a[href]', 'href'));
$crawler->addFilter(new Filters\AllowedSchemesFilter(['http', 'https']));

foreach ($crawler->crawl('https://laravel.com/docs') as $url) {
    echo $url."\n";
}
