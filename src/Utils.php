<?php

declare(strict_types=1);

namespace Buismaarten\UrlScanner;

use League\Uri\Contracts\UriInterface;
use League\Uri\Exceptions\SyntaxError;
use League\Uri\Uri;

final class Utils
{
    public static function validateUrl(string|UriInterface $url): bool
    {
        if (is_string($url)) {
            $url = Uri::new($url);
        }

        if ($url->getScheme() === null || ! str_starts_with($url->getScheme(), 'http')) {
            return false;
        }

        return true;
    }

    public static function normalizeUrl(string $url, ?string $baseUrl): ?UriInterface
    {
        try {
            $components = Uri::fromBaseUri($url, $baseUrl)->withUserInfo(null)->getComponents();
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

    public static function validateHost(string $host): bool
    {
        if (filter_var($host, FILTER_VALIDATE_IP) !== false) {
            return false;
        }

        return true;
    }

    public static function normalizeHost(string $host): string
    {
        if (str_starts_with($host, 'www.')) {
            $host = substr($host, strlen('www.'));
        }

        return $host;
    }
}
