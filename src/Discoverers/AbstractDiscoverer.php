<?php

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

    public function discover(string $content): array
    {
        return $this->getFilteredCrawler($content)->each(function (Crawler $node): string {
            return $node->attr($this->attribute);
        });
    }

    abstract protected function getFilteredCrawler(string $content): Crawler;
}
