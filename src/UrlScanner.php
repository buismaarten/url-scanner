<?php

namespace Buismaarten\UrlScanner;

use Buismaarten\UrlScanner\Contracts\HasClient;
use Buismaarten\UrlScanner\Contracts\HasDetector;
use Buismaarten\UrlScanner\Traits\HasClientTrait;
use Buismaarten\UrlScanner\Traits\HasDetectorTrait;
use League\Uri\Contracts\UriInterface;
use League\Uri\Uri;

final class UrlScanner implements HasClient, HasDetector
{
    use HasClientTrait;
    use HasDetectorTrait;

    /** @return UriInterface[] */
    public function scan(string $url): array
    {
        return $this->getDetector()->detect(Uri::fromBaseUri($url));
    }
}
