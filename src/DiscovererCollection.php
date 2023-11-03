<?php

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

        // @todo: convert relative links to absolute
        // @todo: apply filters
        foreach ($this->discoverers as $discoverer) {
            $results = array_merge($results, $discoverer->discover($resource));
        }

        return $results;
    }
}
