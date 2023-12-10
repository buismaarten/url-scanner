<?php

declare(strict_types=1);

namespace Buismaarten\UrlScanner;

use Buismaarten\UrlScanner\Detectors\AbstractDetector;

final class UrlScanner
{
    public function scan(AbstractDetector $detector): UrlScannerResult
    {
        $detectedUrls = $detector->detect();
        $normalizedUrls = [];

        foreach ($detectedUrls as $detectedUrl) {
            $normalizedUrl = Utils::normalizeUrl($detectedUrl, $detector->getUrl());

            if ($normalizedUrl !== null && Utils::validateUrl($normalizedUrl)) {
                $normalizedUrls[$normalizedUrl->toString()] = $normalizedUrl;
            }
        }

        return new UrlScannerResult($normalizedUrls);
    }
}
