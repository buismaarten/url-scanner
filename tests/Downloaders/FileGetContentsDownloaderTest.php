<?php

declare(strict_types=1);

use Buismaarten\UrlScanner\Downloaders\FileGetContentsDownloader;
use Buismaarten\UrlScanner\Wrappers\FileGetContentsWrapper;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class FileGetContentsDownloaderTest extends TestCase
{
    #[DataProvider('responseProvider')]
    public function testResponse(string $expected, mixed $value): void
    {
        $wrapper = $this->createMock(FileGetContentsWrapper::class);
        $wrapper->method('fileGetContents')->willReturn($value);

        $downloader = new FileGetContentsDownloader;
        $downloader->setWrapper($wrapper);

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
                'return' => 'Hello World!',
            ],
            [
                'expected' => '',
                'return' => '',
            ],
            [
                'expected' => '',
                'return' => false,
            ],
        ];
    }
}
