<?php

namespace Buismaarten\Crawler\Entities;

use Symfony\Component\DomCrawler\Crawler;

final class Resource
{
    private readonly string $url;
    private readonly string $content;

    public function __construct(string $url, string $content)
    {
        $this->url = $url;
        $this->content = $content;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getCrawler(): Crawler
    {
        return new Crawler($this->getContent());
    }
}
