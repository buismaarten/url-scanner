<?php

use Symfony\Component\DomCrawler\Crawler;

class CssSelectorDiscoverer extends AbstractDiscoverer
{
    protected function getFilteredCrawler(Resource $resource): Crawler
    {
        return $resource->getCrawler()->filter($this->selector);
    }
}
