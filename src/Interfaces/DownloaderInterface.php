<?php

declare(strict_types=1);

namespace Buismaarten\UrlScanner\Interfaces;

interface DownloaderInterface
{
    public function download(string $url): string;
}
