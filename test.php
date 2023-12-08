<?php

use Buismaarten\UrlScanner\UrlScanner;

require_once __DIR__.'/vendor/autoload.php';


$result = (new UrlScanner)->scan('https://letsbuildit.nl');

print_r($result->getHosts());
print_r($result->getUrls());
exit;
