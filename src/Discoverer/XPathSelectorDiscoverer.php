<?php

namespace Buismaarten\Crawler\Discoverer;

use Symfony\Component\DomCrawler\Crawler;

class XPathSelectorDiscoverer extends AbstractDiscoverer
{
    public function getFilteredCrawler(Crawler $crawler): Crawler
    {
        return $crawler->filterXPath($this->selector);
    }
}
