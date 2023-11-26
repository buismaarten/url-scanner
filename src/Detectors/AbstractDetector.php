<?php

namespace Buismaarten\UrlScanner\Detectors;

use League\Uri\Contracts\UriInterface;

abstract class AbstractDetector
{
    /** @return UriInterface[] */
    abstract public function detect(UriInterface $url): array;
}
