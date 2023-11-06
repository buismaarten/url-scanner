<?php

namespace Buismaarten\Crawler\Discoverers;

use Buismaarten\Crawler\Entities\Resource;
use Symfony\Component\DomCrawler\Crawler;

abstract class AbstractDiscoverer
{
    protected string $selector;
    protected string $attribute;

    public function __construct(string $selector, string $attribute)
    {
        $this->selector = $selector;
        $this->attribute = $attribute;
    }

    public function discover(Resource $resource): array
    {
        return $this->getCrawler($resource)->each(function (Crawler $node): string {
            return $node->attr($this->attribute);
        });
    }

    abstract protected function getCrawler(Resource $resource): Crawler;
}
