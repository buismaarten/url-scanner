<?php

namespace Buismaarten\Crawler\Discoverers;

use Symfony\Component\DomCrawler;

final class XPathSelectorDiscoverer extends AbstractDiscoverer
{
    public function getFilteredCrawler(DomCrawler\Crawler $crawler): DomCrawler\Crawler
    {
        return $crawler->filterXPath($this->selector);
    }
}
