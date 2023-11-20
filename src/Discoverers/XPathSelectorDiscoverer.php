<?php

namespace Buismaarten\Crawler\Discoverers;

use Symfony\Component\DomCrawler\Crawler;

class XPathSelectorDiscoverer extends AbstractDiscoverer
{
    public function getFilteredCrawler(Crawler $crawler): Crawler
    {
        return $crawler->filterXPath($this->selector);
    }
}
