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

    /** @return int<0, max> */
    protected function getLength(): int
    {
        return max(0, ($this->length ??= self::DEFAULT_LENGTH));
    }
}
