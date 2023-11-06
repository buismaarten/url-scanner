<?php

namespace Buismaarten\Crawler\Discoverers;

use Buismaarten\Crawler\Resource;
use Symfony\Component\DomCrawler\Crawler;

class XPathSelectorDiscoverer extends AbstractDiscoverer
{
    protected function getCrawler(Resource $resource): Crawler
    {
        return $resource->getCrawler()->filterXPath($this->selector);
    }
}
