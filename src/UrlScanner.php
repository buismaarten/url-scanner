<?php

declare(strict_types=1);

namespace Buismaarten\UrlScanner;

use Buismaarten\UrlScanner\Detectors\AbstractDetector;
use Buismaarten\UrlScanner\Detectors\SymfonyDetector;
use League\Uri\Contracts\UriInterface;
use League\Uri\Uri;

final class UrlScanner
{
    private AbstractDetector $detector;

    public function __construct(?AbstractDetector $detector = null)
    {
        $this->setDetector($detector);
    }

    public function setDetector(?AbstractDetector $detector): void
    {
        if ($detector === null) {
            $detector = static::getDefaultDetector();
        }

        $this->detector = $detector;
    }

    public function getDetector(): AbstractDetector
    {
        return $this->detector;
    }

    private static function getDefaultDetector(): AbstractDetector
    {
        return new SymfonyDetector;
    }

    /** @return UriInterface[] */
    public function scan(string $url): array
    {
        return $this->getDetector()->detect(Uri::fromBaseUri($url));
    }
}
