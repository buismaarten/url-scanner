<?php

namespace Buismaarten\UrlScanner;

use Buismaarten\UrlScanner\Contracts\HasClient;
use Buismaarten\UrlScanner\Detectors\AbstractDetector;
use Buismaarten\UrlScanner\Detectors\SymfonyDetector;
use Buismaarten\UrlScanner\Traits\HasClientTrait;
use League\Uri\Contracts\UriInterface;
use League\Uri\Uri;

final class UrlScanner implements HasClient
{
    use HasClientTrait;

    private AbstractDetector $detector;

    // @todo
    public function __construct(?object $client = null, ?AbstractDetector $detector = null)
    {
        $this->setClient($client);
        $this->setDetector($detector);
    }

    public function setDetector(?AbstractDetector $detector): void
    {
        if ($detector === null) {
            $detector = new SymfonyDetector;
        }

        if ($detector instanceof HasClient) {
            $detector->setClient($this->getClient());
        }

        $this->detector = $detector;
    }

    public function getDetector(): AbstractDetector
    {
        return $this->detector;
    }

    /** @return UriInterface[] */
    public function scan(string $url): array
    {
        return $this->getDetector()->detect(Uri::fromBaseUri($url));
    }
}
