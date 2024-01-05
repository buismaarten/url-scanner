<?php

declare(strict_types=1);

namespace Buismaarten\UrlScanner\Downloaders;

use Buismaarten\UrlScanner\Utils;
use Buismaarten\UrlScanner\Wrappers\FileGetContentsWrapper;

class FileGetContentsDownloader extends AbstractDownloader
{
    private FileGetContentsWrapper $wrapper;

    public function __construct(FileGetContentsWrapper $wrapper = null)
    {
        $this->setWrapper($wrapper);
    }

    public function download(string $url): string
    {
        if (! Utils::validateUrl($url)) {
            return '';
        }

        $body = $this->wrapper->file_get_contents($url, false, length: $this->getLength());
        if ($body === false) {
            return '';
        }

        return $body;
    }

    public function setWrapper(?FileGetContentsWrapper $wrapper): void
    {
        if ($wrapper === null) {
            $wrapper = new FileGetContentsWrapper([
                'http' => [
                    'ignore_errors' => true,
                    'method' => 'GET',
                ],
            ]);
        }

        $this->wrapper = $wrapper;
    }
}
