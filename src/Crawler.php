<?php

namespace Buismaarten\Crawler;

use Buismaarten\Crawler\Discoverer\AbstractDiscoverer;
use Buismaarten\Crawler\Downloader\AbstractDownloader;
use Buismaarten\Crawler\Downloader\NativeDownloader;
use Buismaarten\Crawler\Filter\AbstractFilter;
use League\Uri\Contracts\UriInterface;
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

    public function crawl(string $url): array
    {
        $results = [];
        $resource = $this->downloader->download($url);

        if ($resource === null) {
            return [];
        }

        foreach ($this->discoverers as $discoverer) {
            $urls = $discoverer->discover($resource);

            foreach ($urls as $url) {
                $results[] = self::normalizeUrl($url, $resource->getUrl());
            }
        }

        foreach ($this->filters as $filter) {
            $results = array_filter($results, fn (UriInterface $url) => (! $filter->match($url)));
        }

        $results = array_map(fn (UriInterface $url) => $url->toString(), $results);
        $results = array_unique($results);
        $results = array_values($results);

        return $results;
    }

    private static function normalizeUrl(string $url, string $baseUrl): UriInterface
    {
        $components = Uri::fromBaseUri($url, $baseUrl)->getComponents();
        $components['path'] = rtrim($components['path'], '/');

        return Uri::fromComponents([
            'scheme' => $components['scheme'],
            'host'   => $components['host'],
            'port'   => $components['port'],
            'path'   => $components['path'],
            'query'  => $components['query'],
        ]);
    }
}
