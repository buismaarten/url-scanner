<?php

use Buismaarten\UrlScanner\Detectors\SymfonyDetector;
use Buismaarten\UrlScanner\UrlScanner;

require_once __DIR__.'/vendor/autoload.php';


$url = 'https://letsbuildit.nl';

$scanner = new UrlScanner;
$result = $scanner->scan(new SymfonyDetector($url, file_get_contents($url)));

print_r($result->getHosts());
print_r($result->getUrls());
exit;
