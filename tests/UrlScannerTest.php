<?php

declare(strict_types=1);

use Buismaarten\UrlScanner\Downloaders\MockDownloader;
use Buismaarten\UrlScanner\UrlScanner;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class UrlScannerTest extends TestCase
{
    #[DataProvider('scanProvider')]
    public function testScanUsingDownloader(array $expected, string $url, string $content): void
    {
        $scanner = new UrlScanner;
        $scanner->setDownloader(new MockDownloader([$url => $content]));

        $this->assertSame(
            expected: $expected,
            actual: $scanner->scan($url, null)->getUrls(),
        );
    }

    #[DataProvider('scanProvider')]
    public function testScanUsingContent(array $expected, string $url, string $content): void
    {
        $scanner = new UrlScanner;
        $scanner->setDownloader(new MockDownloader);

        $this->assertSame(
            expected: $expected,
            actual: $scanner->scan($url, $content)->getUrls(),
        );
    }

    public static function scanProvider(): array
    {
        return [
            [
                'expected' => [
                    'https://localhost',
                ],
                'url' => 'https://localhost',
                'content' => '<a href="/">Link</a>',
            ],
            [
                'expected' => [
                    'https://localhost',
                ],
                'url' => 'https://localhost',
                'content' => '<a href="https://localhost">Link</a>',
            ],
            [
                'expected' => [],
                'url' => 'https://localhost',
                'content' => '<a href="://localhost">Link</a>',
            ],
        ];
    }
}
