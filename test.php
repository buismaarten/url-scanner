<?php

use Buismaarten\UrlScanner\Detectors\RegexDetector;
use Buismaarten\UrlScanner\Detectors\XPathDetector;
use Buismaarten\UrlScanner\UrlScanner;

require_once __DIR__.'/vendor/autoload.php';


$url = 'https://letsbuildit.nl';

$scanner = new UrlScanner($url, file_get_contents($url));
$scanner->addDetector(new RegexDetector);
$scanner->addDetector(new XPathDetector);

var_dump(
    $scanner->scan()->getHosts(),
    $scanner->scan()->getUrls(),
);
