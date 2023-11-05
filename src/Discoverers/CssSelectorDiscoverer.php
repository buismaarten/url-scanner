<?php

use Symfony\Component\DomCrawler\Crawler;

class CssSelectorDiscoverer extends AbstractDiscoverer
{
    protected function getCrawler(Resource $resource): Crawler
    {
        return $resource->getCrawler()->filter($this->selector);
    }
}
