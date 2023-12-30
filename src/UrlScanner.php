<?php

declare(strict_types=1);

namespace Buismaarten\UrlScanner;

use Buismaarten\UrlScanner\Interfaces\DetectorInterface;
use Buismaarten\UrlScanner\Interfaces\DownloaderInterface;

class UrlScanner
{
    private DownloaderInterface $downloader;

    /** @var DetectorInterface[] */
    private array $detectors;

    public function scan(string $url, ?string $content = null): UrlScannerResult
    {
        $normalizedUrls = [];

        if ($content === null) {
            $content = $this->getDownloader()->download($url);
        }

        foreach ($this->getDetectors() as $detector) {
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

    public function setDownloader(DownloaderInterface $downloader): void
    {
        $this->downloader = $downloader;
    }

    /** @param DetectorInterface[] $detectors */
    public function setDetectors(array $detectors): void
    {
        $this->detectors = $detectors;
    }

    private function getDownloader(): DownloaderInterface
    {
        return ($this->downloader ??= self::getDefaultDownloader());
    }

    /** @return DetectorInterface[] */
    private function getDetectors(): array
    {
        return ($this->detectors ??= self::getDefaultDetectors());
    }

    private static function getDefaultDownloader(): DownloaderInterface
    {
        return new Downloaders\FileGetContentsDownloader;
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
