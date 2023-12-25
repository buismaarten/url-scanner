<?php

declare(strict_types=1);

namespace Buismaarten\UrlScanner\Downloaders;

use Buismaarten\UrlScanner\Interfaces\DownloaderInterface;

final class NativeDownloader implements DownloaderInterface
{
    public function download(string $url): string
    {
        // @todo
        $body = file_get_contents($url, length: (5 * 1024 * 1024));

        if ($body === false) {
            return '';
        }

        return $body;
    }
}
