<?php

namespace Buismaarten\UrlScanner\Detectors;

use Buismaarten\UrlScanner\Contracts\HasClient;
use Buismaarten\UrlScanner\Traits\HasClientTrait;
use League\Uri\Contracts\UriInterface;

abstract class AbstractDetector implements HasClient
{
    use HasClientTrait;

    /** @return UriInterface[] */
    abstract public function detect(UriInterface $url): array;
}
