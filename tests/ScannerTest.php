<?php

declare(strict_types=1);

use Buismaarten\UrlScanner\Downloaders\FileGetContentsDownloader;
use Buismaarten\UrlScanner\Scanner;
use Buismaarten\UrlScanner\Wrappers\FileGetContentsWrapper;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class ScannerTest extends TestCase
{
    #[DataProvider('scanRelativeProvider')]
    #[DataProvider('scanAbsoluteProvider')]
    #[DataProvider('scanInvalidProvider')]
    public function testScanUrlsUsingDownloader(array $expected, string $url, string $content): void
    {
        $wrapper = $this->createMock(FileGetContentsWrapper::class);
        $wrapper->method('fileGetContents')->willReturn($content);

        $scanner = new Scanner;
        $scanner->setDownloader(new FileGetContentsDownloader($wrapper));

        $this->assertSame(
            expected: $expected,
            actual: $scanner->scan($url, null)->getUrls(),
        );
    }

    #[DataProvider('scanRelativeProvider')]
    #[DataProvider('scanAbsoluteProvider')]
    #[DataProvider('scanInvalidProvider')]
    public function testScanUrlsUsingContent(array $expected, string $url, string $content): void
    {
        $wrapper = $this->createMock(FileGetContentsWrapper::class);
        $wrapper->method('fileGetContents')->willReturn($content);

        $scanner = new Scanner;
        $scanner->setDownloader(new FileGetContentsDownloader($wrapper));

        $this->assertSame(
            expected: $expected,
            actual: $scanner->scan($url, $content)->getUrls(),
        );
    }

    public static function scanRelativeProvider(): array
    {
        return [
            [
                'expected' => [
                    'https://localhost',
                ],
                'url' => 'https://localhost',
                'content' => '<a href="/">Link</a>',
            ],
        ];
    }

    public static function scanAbsoluteProvider(): array
    {
        return [
            [
                'expected' => [
                    'https://localhost',
                ],
                'url' => 'https://localhost',
                'content' => '<a href="https://localhost">Link</a>',
            ],
        ];
    }

    public static function scanInvalidProvider(): array
    {
        return [
            [
                'expected' => [],
                'url' => 'https://localhost',
                'content' => '<a href="data:text/plain;base64,SGVsbG8sIFdvcmxkIQ==">Link</a>',
            ],
            [
                'expected' => [],
                'url' => 'https://localhost',
                'content' => '<a href="://localhost">Link</a>',
            ],
        ];
    }
}
