<?php

namespace Buismaarten\Crawler\Discoverers;

use Symfony\Component\DomCrawler\Crawler as DomCrawler;

final class CssSelectorDiscoverer extends AbstractDiscoverer
{
    public function getFilteredCrawler(DomCrawler $domCrawler): DomCrawler
    {
        return $domCrawler->filter($this->selector);
    }
}
