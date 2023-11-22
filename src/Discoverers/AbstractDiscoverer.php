<?php

namespace Buismaarten\Crawler\Discoverers;

use Symfony\Component\DomCrawler;

abstract class AbstractDiscoverer
{
    protected readonly string $selector;
    protected readonly string $attribute;

    public function __construct(string $selector, string $attribute)
    {
        $this->selector = $selector;
        $this->attribute = $attribute;
    }

    public function discover(DomCrawler\Crawler $crawler): array
    {
        return $this->getFilteredCrawler($crawler)->each(function (DomCrawler\Crawler $node): string {
            return ($node->attr($this->attribute) ?? '');
        });
    }

    abstract protected function getFilteredCrawler(DomCrawler\Crawler $crawler): DomCrawler\Crawler;
}
