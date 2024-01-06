<?php

use Buismaarten\UrlScanner\UrlScanner;

require_once __DIR__.'/../vendor/autoload.php';


$scanner = new UrlScanner;
$result = $scanner->scan('https://example.com');

var_dump(
    $result->getHosts(),
    $result->getUrls(),
);
