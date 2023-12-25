<?php

declare(strict_types=1);

namespace Buismaarten\UrlScanner\Downloaders;

use Buismaarten\UrlScanner\Interfaces\DownloaderInterface;
use Buismaarten\UrlScanner\Utils;

final class NativeDownloader implements DownloaderInterface
{
    public function download(string $url): string
    {
        $body = false;

        if (Utils::validateUrl($url)) {
            $body = file_get_contents($url, length: (2 * 1024 * 1024));
        }

        if ($body === false) {
            return '';
        }

        return $body;
    }
}
