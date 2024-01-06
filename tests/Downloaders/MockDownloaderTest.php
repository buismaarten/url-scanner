<?php

declare(strict_types=1);

use Buismaarten\UrlScanner\Downloaders\MockDownloader;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class MockDownloaderTest extends TestCase
{
    public function testResponse(): void
    {
        $downloader = new MockDownloader(['https://localhost' => 'Hello World!']);

        $this->assertSame(
            expected: 'Hello World!',
            actual: $downloader->download('https://localhost'),
        );
    }

    #[DataProvider('responseLengthProvider')]
    public function testResponseLength(string $expected, string $input, int $length): void
    {
        $downloader = new MockDownloader(['https://localhost' => $input]);
        $downloader->setLength($length);

        $this->assertSame(
            expected: $expected,
            actual: $downloader->download('https://localhost'),
        );
    }

    public static function responseLengthProvider(): array
    {
        return [
            [
                'expected' => 'Hello World!',
                'input' => 'Hello World!',
                'length' => 12,
            ],
            [
                'expected' => 'Hello',
                'input' => 'Hello World!',
                'length' => 5,
            ],
        ];
    }
}