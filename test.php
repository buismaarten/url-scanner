<?php

use Buismaarten\Crawler\Crawler;
use Buismaarten\Crawler\Discoverers\CssSelectorDiscoverer;

require_once __DIR__.'/vendor/autoload.php';


$baseUrl = 'https://transip.nl';
$crawler = new Crawler(file_get_contents($baseUrl), $baseUrl);

print_r($crawler->getUrls(new CssSelectorDiscoverer('a[href]', 'href')));
print_r($crawler->getHosts(new CssSelectorDiscoverer('*[href]', 'href')));
