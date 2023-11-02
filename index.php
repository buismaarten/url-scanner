<?php

use Symfony\Component\DomCrawler\Crawler;

require_once __DIR__.'/vendor/autoload.php';


abstract class AbstractDownloader
{
    abstract public function download(string $url): string;
}

class NativeDownloader extends AbstractDownloader
{
    public function download(string $url): string
    {
        return file_get_contents($url);
    }
}

abstract class AbstractSelectorDiscoverer
{
    protected string $selector;

    public function __construct(string $selector)
    {
        $this->selector = $selector;
    }

    public function discover(string $content): array
    {
        // @todo
        return $this->getFilteredCrawler($content)->each(function (Crawler $node) {
            return $node->attr('href');
        });
    }

    abstract protected function getFilteredCrawler(string $content): Crawler;
}

class CssSelectorDiscoverer extends AbstractSelectorDiscoverer
{
    protected function getFilteredCrawler(string $content): Crawler
    {
        return (new Crawler($content))->filter($this->selector);
    }
}

class SelectorDiscovererCollection
{
    private array $selectorDiscoverers;

    public function __construct()
    {
        $this->selectorDiscoverers = [];
    }

    public function add(AbstractSelectorDiscoverer $selectorDiscoverer): void
    {
        $this->selectorDiscoverers[] = $selectorDiscoverer;
    }

    public function discover(string $content): array
    {
        $results = [];

        foreach ($this->selectorDiscoverers as $selectorDiscoverer) {
            $results[] = $selectorDiscoverer->discover($content);
        }

        return $results;
    }
}

class Spider
{
    private AbstractDownloader $downloader;
    private SelectorDiscovererCollection $selectorDiscovererCollection;

    public function __construct(AbstractDownloader $downloader = null, SelectorDiscovererCollection $selectorDiscovererCollection = null)
    {
        $this->downloader = ($downloader ?? new NativeDownloader);
        $this->selectorDiscovererCollection = ($selectorDiscovererCollection ?? new SelectorDiscovererCollection);
    }

    public function getDownloader(): AbstractDownloader
    {
        return $this->downloader;
    }

    public function getSelectorDiscovererCollection(): SelectorDiscovererCollection
    {
        return $this->selectorDiscovererCollection;
    }

    public function crawl(string $url): array
    {
        $content = $this->getDownloader()->download($url);
        $results = $this->getSelectorDiscovererCollection()->discover($content);

        return $results;
    }
}



$spider = new Spider;
$spider->getSelectorDiscovererCollection()->add(new CssSelectorDiscoverer('a'));

print_r($spider->crawl('https://www.google.com'));
