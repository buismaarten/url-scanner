<?php

declare(strict_types=1);

use Buismaarten\UrlScanner\Downloaders\MockDownloader;
use Buismaarten\UrlScanner\UrlScanner;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class UrlScannerTest extends TestCase
{
    #[DataProvider('scanProvider')]
    public function testScanUsingDownloader(array $expected, string $content): void
    {
        $scanner = new UrlScanner;
        $scanner->setDownloader(new MockDownloader(['https://localhost' => $content]));

        $this->assertSame(
            expected: $expected,
            actual: $scanner->scan('https://localhost', null)->getUrls(),
        );
    }

    #[DataProvider('scanProvider')]
    public function testScanUsingContent(array $expected, string $content): void
    {
        $scanner = new UrlScanner;
        $scanner->setDownloader(new MockDownloader);

        $this->assertSame(
            expected: $expected,
            actual: $scanner->scan('https://localhost', $content)->getUrls(),
        );
    }

    public static function scanProvider(): array
    {
        return [
            [
                'expected' => [
                    'https://localhost',
                ],
                'content' => '<a href="https://localhost"></a><a href="https://localhost/"></a>',
            ],
            [
                'expected' => [
                    'https://localhost',
                ],
                'content' => '<a href=""></a><a href="/"></a>',
            ],
            [
                'expected' => [
                    'https://localhost',
                ],
                'content' => '<a href="#"></a>',
            ],
            [
                'expected' => [],
                'content' => '<a href="mailto:root@localhost"></a>',
            ],
        ];
    }
}
