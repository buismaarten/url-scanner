<?php

namespace Buismaarten\Crawler\Discoverer;

use Buismaarten\Crawler\Entities\Resource;
use Symfony\Component\DomCrawler\Crawler;

class XPathSelectorDiscoverer extends AbstractDiscoverer
{
    protected function getCrawler(Resource $resource): Crawler
    {
        return $resource->getCrawler()->filterXPath($this->selector);
    }
}
