<?php

declare(strict_types=1);

namespace Buismaarten\UrlScanner;

use Buismaarten\UrlScanner\Detectors\AbstractDetector;
use Buismaarten\UrlScanner\Detectors\SymfonyDetector;
use League\Uri\Contracts\UriInterface;
use League\Uri\Exceptions\SyntaxError;
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

    // @todo
    /** @return string[] */
    public function scan(string $url): array
    {
        $detectedUrls = $this->getDetector()->detect(Uri::fromBaseUri($url));
        $normalizedUrls = [];

        foreach ($detectedUrls as $detectedUrl) {
            $normalizedUrl = self::normalizeUrl($detectedUrl, $url);

            if ($normalizedUrl !== null) {
                $normalizedUrls[] = $normalizedUrl->toString();
            }
        }

        return $normalizedUrls;
    }

    private static function normalizeUrl(string $url, ?string $baseUrl): ?UriInterface
    {
        try {
            $components = Uri::fromBaseUri($url, $baseUrl)->getComponents();
            $components['path'] = rtrim($components['path'], '/');
        } catch (SyntaxError) {
            return null;
        }

        return Uri::fromComponents([
            'scheme' => $components['scheme'],
            'host'   => $components['host'],
            'port'   => $components['port'],
            'path'   => $components['path'],
            'query'  => $components['query'],
        ]);
    }
}
