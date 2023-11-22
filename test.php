<?php

use Buismaarten\Crawler\Crawler;
use Buismaarten\Crawler\Discoverers\CssSelectorDiscoverer;

require_once __DIR__.'/vendor/autoload.php';


$baseUrl = 'https://letsbuildit.nl';
$html = file_get_contents($baseUrl);
$crawler = new Crawler($html, $baseUrl);

print_r($crawler->getUrls(new CssSelectorDiscoverer('a[href]', 'href')));
exit;
