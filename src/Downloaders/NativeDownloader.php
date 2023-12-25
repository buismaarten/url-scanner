<?php

declare(strict_types=1);

namespace Buismaarten\UrlScanner\Downloaders;

use Buismaarten\UrlScanner\Utils;

final class NativeDownloader extends AbstractDownloader
{
    public function download(string $url): string
    {
        $body = false;

        if (Utils::validateUrl($url)) {
            $body = file_get_contents($url, length: $this->getLength());
        }

        if ($body === false) {
            return '';
        }

        return $body;
    }
}
