<?php

class NativeDownloader extends AbstractDownloader
{
    public function download(string $url): Resource
    {
        // @todo: error handling
        return new Resource($url, file_get_contents($url));
    }
}
