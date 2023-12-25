<?php

declare(strict_types=1);

namespace Buismaarten\UrlScanner\Downloaders;

use Buismaarten\UrlScanner\Interfaces\DownloaderInterface;

class NativeDownloader implements DownloaderInterface
{
    public function download(string $url): string
    {
        if ($body = file_get_contents($url)) {
            return $body;
        }

        return '';
    }
}
