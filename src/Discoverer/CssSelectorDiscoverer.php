<?php

namespace Buismaarten\Crawler\Discoverer;

use Symfony\Component\DomCrawler\Crawler;

class CssSelectorDiscoverer extends AbstractDiscoverer
{
    public function getFilteredCrawler(Crawler $crawler): Crawler
    {
        return $crawler->filter($this->selector);
    }
}
