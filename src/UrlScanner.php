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

    public function setDetector(AbstractDetector $detector): void
    {
        $this->detector = $detector;
    }

    public function getDetector(): AbstractDetector
    {
        if (! isset($this->detector)) {
            $this->setDetector(static::getDefaultDetector());
        }

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
