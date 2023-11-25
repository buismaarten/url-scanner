<?php

namespace Buismaarten\Crawler\Discoverers;

use Symfony\Component\DomCrawler\Crawler as DomCrawler;

final class XPathSelectorDiscoverer extends AbstractDiscoverer
{
    public function getFilteredCrawler(DomCrawler $domCrawler): DomCrawler
    {
        return $domCrawler->filterXPath($this->selector);
    }
}
