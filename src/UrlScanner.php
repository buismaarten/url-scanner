<?php

declare(strict_types=1);

namespace Buismaarten\UrlScanner;

use Buismaarten\UrlScanner\Interfaces\DetectorInterface;
use Buismaarten\UrlScanner\Interfaces\DownloaderInterface;

final class UrlScanner
{
    private DownloaderInterface $downloader;

    /** @var DetectorInterface[] */
    private array $detectors;

    public function setDownloader(DownloaderInterface $downloader): void
    {
        $this->downloader = $downloader;
    }

    public function addDetector(DetectorInterface $detector): void
    {
        $this->detectors[] = $detector;
    }

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

    private function getDownloader(): DownloaderInterface
    {
        if (! isset($this->downloader)) {
            $this->downloader = self::getDefaultDownloader();
        }

        return $this->downloader;
    }

    private static function getDefaultDownloader(): DownloaderInterface
    {
        return new Downloaders\NativeDownloader;
    }

    /** @return DetectorInterface[] */
    private function getDetectors(): array
    {
        if (! isset($this->detectors)) {
            $this->detectors = self::getDefaultDetectors();
        }

        return $this->detectors;
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
