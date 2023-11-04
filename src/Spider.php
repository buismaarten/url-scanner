<?php

class Spider
{
    private AbstractDownloader $downloader;
    private DiscovererCollection $discovererCollection;

    public function __construct(AbstractDownloader $downloader = null, DiscovererCollection $discovererCollection = null)
    {
        $this->downloader = ($downloader ?? new NativeDownloader);
        $this->discovererCollection = ($discovererCollection ?? new DiscovererCollection);
    }

    public function getDownloader(): AbstractDownloader
    {
        return $this->downloader;
    }

    public function getDiscovererCollection(): DiscovererCollection
    {
        return $this->discovererCollection;
    }

    public function crawl(string $url): array
    {
        $resource = $this->getDownloader()->download($url);

        // @todo: error handling
        if ($resource === null) {
            return [];
        }

        return $this->getDiscovererCollection()->crawl($resource);
    }
}
