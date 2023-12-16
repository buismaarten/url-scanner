<?php

declare(strict_types=1);

namespace Buismaarten\UrlScanner;

use Buismaarten\UrlScanner\Detectors\AbstractDetector;
use League\Uri\Contracts\UriInterface;

final class UrlScanner
{
    private string $url;
    private string $content;

    /** @var AbstractDetector[] */
    private array $detectors = [];

    public function __construct(string $url, string $content = '')
    {
        $this->url = $url;
        $this->content = $content;
    }

    public function addDetector(AbstractDetector $detector): void
    {
        $this->detectors[] = $detector;
    }

    public function scan(): UrlScannerResult
    {
        $normalizedUrls = [];

        foreach ($this->detectors as $detector) {
            $detectedUrls = $detector->detect($this->url, $this->content);

            foreach ($detectedUrls as $detectedUrl) {
                $normalizedUrl = Utils::normalizeUrl($detectedUrl, $this->url);

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
