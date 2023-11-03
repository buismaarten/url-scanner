<?php

class NativeDownloader extends AbstractDownloader
{
    public function download(string $url): ?Resource
    {
        $content = file_get_contents($url);

        if ($content === false) {
            return null;
        }

        return new Resource($url, $content);
    }
}
