<?php

$json_string = file_get_contents('https://letsbuildit.nl');

$pattern = '/":\s*"((https?:\/\/[^"]+))"/';
preg_match_all($pattern, $json_string, $matches);

$urls = $matches[1];
print_r($urls);
