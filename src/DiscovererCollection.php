<?php

use Symfony\Component\DomCrawler\UriResolver;

class DiscovererCollection
{
    /** @var AbstractDiscoverer[] */
    private array $discoverers = [];

    /** @var AbstractFilter[] */
    private array $filters = [];

    public function addDiscoverer(AbstractDiscoverer $discoverer): void
    {
        $this->discoverers[] = $discoverer;
    }

    public function addFilter(AbstractFilter $filter): void
    {
        $this->filters[] = $filter;
    }

    public function discover(Resource $resource): array
    {
        $results = [];

        foreach ($this->discoverers as $discoverer) {
            $urls = $discoverer->discover($resource);

            foreach ($urls as $url) {
                $results[] = UriResolver::resolve($url, $resource->getUrl());
            }
        }

        foreach ($this->filters as $filter) {
            $results = array_filter($results, function (string $url) use ($filter): bool {
                return ($filter->match($url) === false);
            });
        }

        return $results;
    }
}
