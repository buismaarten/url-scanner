<?php

declare(strict_types=1);

use Buismaarten\UrlScanner\Downloaders\MockDownloader;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class MockDownloaderTest extends TestCase
{
    #[DataProvider('responseProvider')]
    public function testResponse(string $expected, mixed $value): void
    {
        $downloader = new MockDownloader(['https://localhost' => $value]);

        $this->assertSame(
            expected: $expected,
            actual: $downloader->download('https://localhost'),
        );
    }

    public static function responseProvider(): array
    {
        return [
            [
                'expected' => 'Hello World!',
                'value' => 'Hello World!',
            ],
            [
                'expected' => '',
                'value' => '',
            ],
        ];
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
