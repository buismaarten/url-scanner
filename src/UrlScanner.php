<?php

declare(strict_types=1);

namespace Buismaarten\UrlScanner;

use Buismaarten\UrlScanner\Detectors\AbstractDetector;
use Buismaarten\UrlScanner\Detectors\SymfonyDetector;
use League\Uri\Uri;

final class UrlScanner
{
    private AbstractDetector $detector;

    public function __construct(AbstractDetector $detector = null)
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
        if (! isset($this->detector)) {
            $this->setDetector(static::getDefaultDetector());
        }

        return $this->detector;
    }

    private static function getDefaultDetector(): AbstractDetector
    {
        return new SymfonyDetector;
    }

    // @todo: filter protocols
    // @todo: respect robots.txt
    public function scan(string $url): UrlScannerResult
    {
        $detectedUrls = $this->getDetector()->detect(Uri::fromBaseUri($url));
        $normalizedUrls = [];

        foreach ($detectedUrls as $detectedUrl) {
            $normalizedUrl = Utils::normalizeUrl($detectedUrl, $url);

            if ($normalizedUrl !== null) {
                $normalizedUrls[$normalizedUrl->toString()] = $normalizedUrl;
            }
        }

        return new UrlScannerResult($normalizedUrls);
    }
}
