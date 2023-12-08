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

    // @todo: filter protocols
    /** @return UriInterface[] */
    public function scan(string $url): array
    {
        $detectedUrls = $this->getDetector()->detect(Uri::fromBaseUri($url));
        $normalizedUrls = [];

        foreach ($detectedUrls as $detectedUrl) {
            $normalizedUrl = Utils::normalizeUrl($detectedUrl, $url);

            if ($normalizedUrl !== null) {
                $normalizedUrls[$normalizedUrl->toString()] = $normalizedUrl;
            }
        }

        return array_values($normalizedUrls);
    }

    /** @return string[] */
    public function getUrls(string $url): array
    {
        return array_map(fn (UriInterface $uri): string => $uri->toString(), $this->scan($url));
    }
}
