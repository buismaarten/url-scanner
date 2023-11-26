<?php

use Buismaarten\UrlScanner\UrlScanner;

require_once __DIR__.'/vendor/autoload.php';


$scanner = new UrlScanner;

print_r($scanner->scan('https://www.google.com'));
exit;
