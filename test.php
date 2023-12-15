<?php

use Buismaarten\UrlScanner\Detectors\RegexDetector;
use Buismaarten\UrlScanner\Detectors\XPathDetector;
use Buismaarten\UrlScanner\UrlScanner;

require_once __DIR__.'/vendor/autoload.php';


$url = 'https://letsbuildit.nl';
$content = file_get_contents($url);

$scanner = new UrlScanner;
$scannerResult = $scanner->scan([new RegexDetector($url, $content), new XPathDetector($url, $content)]);

print_r($scannerResult->getHosts());
print_r($scannerResult->getUrls());
exit;
