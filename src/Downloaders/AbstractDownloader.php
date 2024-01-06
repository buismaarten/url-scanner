<?php

declare(strict_types=1);

namespace Buismaarten\UrlScanner\Downloaders;

use Buismaarten\UrlScanner\Interfaces\DownloaderInterface;

abstract class AbstractDownloader implements DownloaderInterface
{
    private const DEFAULT_LENGTH = 2 * (1024 * 1024);
    private int $length;

    public function setLength(int $length): void
    {
        $this->length = $length;
    }

    protected function getLength(): int
    {
        return ($this->length ??= self::DEFAULT_LENGTH);
    }
}
