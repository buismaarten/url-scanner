<?php

namespace Buismaarten\Crawler\Discoverers;

use Symfony\Component\DomCrawler\Crawler as DomCrawler;

abstract class AbstractDiscoverer
{
    protected readonly string $selector;
    protected readonly string $attribute;

    public function __construct(string $selector, string $attribute)
    {
        $this->selector = $selector;
        $this->attribute = $attribute;
    }

    public function discover(DomCrawler $domCrawler): array
    {
        return $this->getFilteredCrawler($domCrawler)->each(function (DomCrawler $node): string {
            return ($node->attr($this->attribute) ?? '');
        });
    }

    abstract protected function getFilteredCrawler(DomCrawler $domCrawler): DomCrawler;
}
