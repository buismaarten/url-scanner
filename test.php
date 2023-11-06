<?php

use Buismaarten\Crawler\Discoverers\CssSelectorDiscoverer;
use Buismaarten\Crawler\Filters\AllowedSchemeFilter;
use Buismaarten\Crawler\Spider;

require_once __DIR__.'/vendor/autoload.php';


$spider = new Spider;
$spider->addDiscoverer(new CssSelectorDiscoverer('a[href]', 'href'));
$spider->addFilter(new AllowedSchemeFilter(['http', 'https']));

print_r($spider->crawl('https://laravel.com/docs'));
exit;
