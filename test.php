<?php

use Buismaarten\Crawler\Discoverers\CssSelectorDiscoverer;
use Buismaarten\Crawler\Filters\AllowedSchemeFilter;
use Buismaarten\Crawler\Crawler;

require_once __DIR__.'/vendor/autoload.php';


$crawler = new Crawler;
$crawler->addDiscoverer(new CssSelectorDiscoverer('a[href]', 'href'));
$crawler->addFilter(new AllowedSchemeFilter(['http', 'https']));

foreach ($crawler->crawl('https://laravel.com/docs') as $url) {
    echo $url."\n";
}
