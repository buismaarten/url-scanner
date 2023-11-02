<?php

class NativeDownloader extends AbstractDownloader
{
    public function download(string $url): string
    {
        return file_get_contents($url);
    }
}
