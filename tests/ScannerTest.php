<?php

declare(strict_types=1);

use Buismaarten\UrlScanner\Downloaders\MockDownloader;
use Buismaarten\UrlScanner\Scanner;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class ScannerTest extends TestCase
{
    #[DataProvider('scanRelativeProvider')]
    #[DataProvider('scanAbsoluteProvider')]
    #[DataProvider('scanInvalidProvider')]
    public function testScanUsingDownloader(array $expected, string $url, string $content): void
    {
        $scanner = new Scanner;
        $scanner->setDownloader(new MockDownloader([$url => $content]));

        $this->assertSame(
            expected: $expected,
            actual: $scanner->scan($url, null)->getUrls(),
        );
    }

    #[DataProvider('scanRelativeProvider')]
    #[DataProvider('scanAbsoluteProvider')]
    #[DataProvider('scanInvalidProvider')]
    public function testScanUsingContent(array $expected, string $url, string $content): void
    {
        $scanner = new Scanner;
        $scanner->setDownloader(new MockDownloader);

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
                'expected' => [
                    //
                ],
                'url' => 'https://localhost',
                'content' => '<a href="://localhost">Link</a>',
            ],
        ];
    }
}
