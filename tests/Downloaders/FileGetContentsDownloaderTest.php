<?php

declare(strict_types=1);

use Buismaarten\UrlScanner\Downloaders\FileGetContentsDownloader;
use Buismaarten\UrlScanner\Wrappers\FileGetContentsWrapper;
use PHPUnit\Framework\TestCase;

class FileGetContentsDownloaderTest extends TestCase
{
    public function testResponse(): void
    {
        $wrapper = $this->createMock(FileGetContentsWrapper::class);
        $wrapper->method('fileGetContents')->willReturn('Hello World!');

        $downloader = new FileGetContentsDownloader;
        $downloader->setWrapper($wrapper);

        $this->assertSame(
            expected: 'Hello World!',
            actual: $downloader->download('https://localhost'),
        );
    }

    // @todo: move to data provider
    public function testInvalidResponse(): void
    {
        $wrapper = $this->createMock(FileGetContentsWrapper::class);
        $wrapper->method('fileGetContents')->willReturn(false);

        $downloader = new FileGetContentsDownloader;
        $downloader->setWrapper($wrapper);

        $this->assertSame(
            expected: '',
            actual: $downloader->download('https://localhost'),
        );
    }
}
