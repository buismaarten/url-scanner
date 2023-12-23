<?php

declare(strict_types=1);

namespace Buismaarten\UrlScanner;

use Buismaarten\UrlScanner\Interfaces\DetectorInterface;
use League\Uri\Contracts\UriInterface;

final class UrlScanner
{
    /** @var DetectorInterface[] */
    private array $detectors = [];

    public function addDetector(DetectorInterface $detector): void
    {
        $this->detectors[] = $detector;
    }

    public function scan(string $url, string $content = ''): UrlScannerResult
    {
        $normalizedUrls = [];

        if ($this->detectors === []) {
            $this->detectors = self::getDefaultDetectors();
        }

        foreach ($this->detectors as $detector) {
            $detectedUrls = $detector->detect($url, $content);

            foreach ($detectedUrls as $detectedUrl) {
                $normalizedUrl = Utils::normalizeUrl($detectedUrl, $url);

                if ($normalizedUrl !== null && Utils::validateUrl($normalizedUrl)) {
                    $normalizedUrls[$normalizedUrl->toString()] = $normalizedUrl;
                }
            }
        }

        return new UrlScannerResult($normalizedUrls);
    }

    /** @return DetectorInterface[] */
    private static function getDefaultDetectors(): array
    {
        return [
            new Detectors\RegexDetector,
            new Detectors\XPathDetector,
        ];
    }
}
