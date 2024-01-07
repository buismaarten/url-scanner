<?php

use Buismaarten\UrlScanner\Scanner;

require_once __DIR__.'/../vendor/autoload.php';


$scanner = new Scanner;
$result = $scanner->scan('https://example.com');

var_dump(
    $result->getHosts(),
    $result->getUrls(),
);
