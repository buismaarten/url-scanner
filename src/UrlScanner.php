<?php

namespace Buismaarten\UrlScanner;

use Buismaarten\UrlScanner\Detectors\AbstractDetector;
use League\Uri\Contracts\UriInterface;
use League\Uri\Uri;

final class UrlScanner
{
    private AbstractDetector $detector;

    public function __construct(?AbstractDetector $detector = null)
    {
        if ($detector !== null) {
            $this->setDetector($detector);
        }
    }

    public function setDetector(AbstractDetector $detector): void
    {
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
