<?php

namespace Buismaarten\Crawler\Discoverers;

use Symfony\Component\DomCrawler;

final class CssSelectorDiscoverer extends AbstractDiscoverer
{
    public function getFilteredCrawler(DomCrawler\Crawler $crawler): DomCrawler\Crawler
    {
        return $crawler->filter($this->selector);
    }
}
