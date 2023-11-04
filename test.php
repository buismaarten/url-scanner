<?php

require_once __DIR__.'/vendor/autoload.php';

require_once __DIR__.'/src/Downloaders/AbstractDownloader.php';
require_once __DIR__.'/src/Downloaders/NativeDownloader.php';

require_once __DIR__.'/src/Discoverers/AbstractDiscoverer.php';
require_once __DIR__.'/src/Discoverers/CssSelectorDiscoverer.php';
require_once __DIR__.'/src/Discoverers/XPathSelectorDiscoverer.php';

require_once __DIR__.'/src/Filters/AbstractFilter.php';
require_once __DIR__.'/src/Filters/AllowedSchemeFilter.php';

require_once __DIR__.'/src/Resource.php';
require_once __DIR__.'/src/Spider.php';


$spider = new Spider;
$spider->addDiscoverer(new CssSelectorDiscoverer('a[href]', 'href'));
$spider->addFilter(new AllowedSchemeFilter(['http', 'https']));

print_r($spider->crawl('https://laravel.com/docs'));
exit;
