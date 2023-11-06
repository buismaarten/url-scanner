<?php

namespace Buismaarten\Crawler;

use Buismaarten\Crawler\Discoverers\AbstractDiscoverer;
use Buismaarten\Crawler\Downloaders\AbstractDownloader;
use Buismaarten\Crawler\Downloaders\NativeDownloader;
use Buismaarten\Crawler\Filters\AbstractFilter;
use Symfony\Component\DomCrawler\UriResolver;

class Crawler
{
    private AbstractDownloader $downloader;

    /** @var AbstractDiscoverer[] */
    private array $discoverers = [];

    /** @var AbstractFilter[] */
    private array $filters = [];

    /**
     * @param AbstractDiscoverer[] $discoverers
     * @param AbstractFilter[]     $filters
     */
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
            $results = array_filter($results, fn (string $url) => ($filter->match($url) === false));
        }

        $results = array_unique($results);
        $results = array_values($results);

        return $results;
    }

    private static function normalizeUrl(string $url, string $baseUrl): string
    {
        $url = UriResolver::resolve($url, $baseUrl);
        $url = rtrim($url, '/');

        return $url;
    }
}
