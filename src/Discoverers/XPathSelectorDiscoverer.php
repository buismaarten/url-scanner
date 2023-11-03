<?php

use Symfony\Component\DomCrawler\Crawler;

class XPathSelectorDiscoverer extends AbstractDiscoverer
{
    protected function getFilteredCrawler(Resource $resource): Crawler
    {
        return $resource->getCrawler()->filterXPath($this->selector);
    }
}
