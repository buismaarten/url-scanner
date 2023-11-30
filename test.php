<?php

use Buismaarten\UrlScanner\UrlScanner;

require_once __DIR__.'/vendor/autoload.php';


// @todo
$scanner = new UrlScanner;
$scanner->setDetector(new \Buismaarten\UrlScanner\Detectors\SymfonyDetector(new \GuzzleHttp\Client));

print_r($scanner->scan('https://letsbuildit.nl'));
