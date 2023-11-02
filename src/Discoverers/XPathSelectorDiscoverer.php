<?php

use Symfony\Component\DomCrawler\Crawler;

class XPathSelectorDiscoverer extends AbstractDiscoverer
{
    protected function getFilteredCrawler(string $content): Crawler
    {
        return (new Crawler($content))->filterXPath($this->selector);
    }
}
