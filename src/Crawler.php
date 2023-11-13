<?php

namespace Buismaarten\Crawler;

use Buismaarten\Crawler\Discoverer\AbstractDiscoverer;
use Buismaarten\Crawler\Downloader\AbstractDownloader;
use Buismaarten\Crawler\Downloader\NativeDownloader;
use Buismaarten\Crawler\Filter\AbstractFilter;
use League\Uri\Contracts\UriInterface;
use League\Uri\Exceptions\SyntaxError;
use League\Uri\Uri;

final class Crawler
{
    private AbstractDownloader $downloader;

    private array $discoverers = [];
    private array $filters = [];

    public function __construct(AbstractDownloader $downloader = null, array $discoverers = [], array $filters = [])
    {
        $this->downloader = ($downloader ?? new NativeDownloader);

        $this->discoverers = $discoverers;
        $this->filters = $filters;
    }

    public function setDownloader(AbstractDownloader $downloader): void
    {
        $this->downloader = $downloader;
    }

    public function addDiscoverer(AbstractDiscoverer $discoverer): void
    {
        $this->discoverers[] = $discoverer;
    }

    public function addFilter(AbstractFilter $filter): void
    {
        $this->filters[] = $filter;
    }

    public function crawl(string $input): array
    {
        $resource = $this->downloader->download($input);
        $urls = [];

        if ($resource === null) {
            return [];
        }

        foreach ($this->discoverers as $discoverer) {
            $discoveredUrls = $discoverer->discover($resource);

            foreach ($discoveredUrls as $discoveredUrl) {
                $normalizedUrl = self::normalizeUrl($discoveredUrl, $resource->getUrl());

                if ($normalizedUrl !== null) {
                    $urls[] = $normalizedUrl;
                }
            }
        }

        foreach ($this->filters as $filter) {
            $urls = array_filter($urls, fn (UriInterface $url) => (! $filter->match($url)));
        }

        $urls = array_map(fn (UriInterface $url) => $url->toString(), $urls);
        $urls = array_unique($urls);
        $urls = array_values($urls);

        return $urls;
    }

    private static function normalizeUrl(string $url, string $baseUrl): ?UriInterface
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
