<?php

use Symfony\Component\DomCrawler\UriResolver;

class DiscovererCollection
{
    private array $discoverers = [];
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

            // @todo: apply filters
            foreach ($urls as $url) {
                $results[] = UriResolver::resolve($url, $resource->getUrl());
            }
        }

        return $results;
    }
}
