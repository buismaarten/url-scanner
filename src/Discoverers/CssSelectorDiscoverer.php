<?php

use Symfony\Component\DomCrawler\Crawler;

class CssSelectorDiscoverer extends AbstractDiscoverer
{
    protected function getFilteredCrawler(string $content): Crawler
    {
        return (new Crawler($content))->filter($this->selector);
    }
}
