<?php

declare(strict_types=1);

namespace Buismaarten\UrlScanner;

use Buismaarten\UrlScanner\Interfaces\DetectorInterface;
use Buismaarten\UrlScanner\Interfaces\DownloaderInterface;

class UrlScanner
{
    private DownloaderInterface $downloader;

    /** @var DetectorInterface[] */
    private array $detectors = [];

    /** @param DetectorInterface[] $detectors */
    public function __construct(DownloaderInterface $downloader = null, array $detectors = [])
    {
        $this->setDownloader($downloader);
        $this->setDetectors($detectors);
    }

    public function scan(string $url, ?string $content = null): UrlScannerResult
    {
        $normalizedUrls = [];

        if ($content === null) {
            $content = $this->downloader->download($url);
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

    public function setDownloader(?DownloaderInterface $downloader): void
    {
        if ($downloader === null) {
            $downloader = new Downloaders\FileGetContentsDownloader;
        }

        $this->downloader = $downloader;
    }

    /** @param DetectorInterface[] $detectors */
    public function setDetectors(array $detectors): void
    {
        if ($detectors === []) {
            $detectors[] = new Detectors\RegexDetector;
            $detectors[] = new Detectors\XPathDetector;
        }

        $this->detectors = $detectors;
    }
}
