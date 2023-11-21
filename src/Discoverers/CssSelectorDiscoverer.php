<?php

namespace Buismaarten\Crawler\Discoverers;

use Symfony\Component\DomCrawler\Crawler;

final class CssSelectorDiscoverer extends AbstractDiscoverer
{
    public function getFilteredCrawler(Crawler $crawler): Crawler
    {
        return $crawler->filter($this->selector);
    }
}
