<?php

declare(strict_types=1);

namespace Buismaarten\UrlScanner\Downloaders;

use Buismaarten\UrlScanner\Interfaces\DownloaderInterface;

abstract class AbstractDownloader implements DownloaderInterface
{
    private const DEFAULT_LENGTH = 2 * (1024 * 1024);
    private const DEFAULT_USER_AGENT = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.3';

    private int $length;
    private string $userAgent;

    public function setLength(int $length): void
    {
        $this->length = $length;
    }

    public function setUserAgent(string $userAgent): void
    {
        $this->userAgent = $userAgent;
    }

    /** @return int<0, max> */
    protected function getLength(): int
    {
        return max(0, ($this->length ??= self::DEFAULT_LENGTH));
    }

    protected function getUserAgent(): string
    {
        return ($this->userAgent ??= self::DEFAULT_USER_AGENT);
    }
}