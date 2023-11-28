<?php

namespace Buismaarten\UrlScanner;

use Buismaarten\UrlScanner\Contracts\HasClient;
use Buismaarten\UrlScanner\Contracts\HasDetector;
use Buismaarten\UrlScanner\Detectors\AbstractDetector;
use Buismaarten\UrlScanner\Traits\HasClientTrait;
use Buismaarten\UrlScanner\Traits\HasDetectorTrait;
use GuzzleHttp\Client;
use League\Uri\Contracts\UriInterface;
use League\Uri\Uri;

final class UrlScanner implements HasClient, HasDetector
{
    use HasClientTrait;
    use HasDetectorTrait;

    public function __construct(?Client $client = null, ?AbstractDetector $detector = null)
    {
        $this->setClient($client);
        $this->setDetector($detector);
    }

    /** @return UriInterface[] */
    public function scan(string $url): array
    {
        return $this->getDetector()->detect(Uri::fromBaseUri($url));
    }
}
