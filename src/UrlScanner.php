<?php

declare(strict_types=1);

namespace Buismaarten\UrlScanner;

use Buismaarten\UrlScanner\Detectors\AbstractDetector;
use League\Uri\Contracts\UriInterface;

final class UrlScanner
{
    /** @param AbstractDetector[]|AbstractDetector $detectors */
    public function scan(array|AbstractDetector $detectors): UrlScannerResult
    {
        $normalizedUrls = [];

        if (! is_iterable($detectors)) {
            $detectors = [$detectors];
        }

        foreach ($detectors as $detector) {
            $detectedUrls = $detector->detect();

            foreach ($detectedUrls as $detectedUrl) {
                $normalizedUrl = Utils::normalizeUrl($detectedUrl, $detector->getUrl());

                if ($normalizedUrl !== null && static::validateUrl($normalizedUrl)) {
                    $normalizedUrls[$normalizedUrl->toString()] = $normalizedUrl;
                }
            }
        }

        return new UrlScannerResult($normalizedUrls);
    }

    private static function validateUrl(UriInterface $url): bool
    {
        if ($url->getScheme() === null || ! str_starts_with($url->getScheme(), 'http')) {
            return false;
        }

        return true;
    }
}
