<?php

class NativeDownloader extends AbstractDownloader
{
    public function download(string $url): string
    {
        // @todo: error handling
        return file_get_contents($url);
    }
}
