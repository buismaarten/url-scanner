<?php

namespace Buismaarten\Crawler\Discoverers;

use Symfony\Component\DomCrawler\Crawler as DomCrawler;

abstract class AbstractDiscoverer
{
    public function __construct(protected readonly string $selector,
                                protected readonly string $attribute)
    {
    }

    /** @return string[] */
    public function discover(DomCrawler $domCrawler): array
    {
        return $this->getFilteredCrawler($domCrawler)->each(function (DomCrawler $node): string {
            return ($node->attr($this->attribute) ?? '');
        });
    }

    abstract protected function getFilteredCrawler(DomCrawler $domCrawler): DomCrawler;
}
