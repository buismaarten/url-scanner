<?php

use Buismaarten\UrlScanner\UrlScanner;

require_once __DIR__.'/vendor/autoload.php';


$url = 'https://letsbuildit.nl';

$scanner = new UrlScanner;
$scannerResult = $scanner->scan($url, file_get_contents($url));

var_dump(
    $scannerResult->getHosts(),
    $scannerResult->getUrls(),
);
