<?php

use Symfony\Component\DomCrawler\Crawler;

class Resource
{
    private string $url;
    private string $content;

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
        return new Crawler($this->content);
    }
}
