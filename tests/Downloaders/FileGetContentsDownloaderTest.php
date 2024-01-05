<?php

declare(strict_types=1);

use Buismaarten\UrlScanner\Downloaders\FileGetContentsDownloader;
use Buismaarten\UrlScanner\Wrappers\FileGetContentsWrapper;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class FileGetContentsDownloaderTest extends TestCase
{
    #[DataProvider('responseLengthProvider')]
    public function testResponseLength(string $expected, string $input, int $length): void
    {
        $wrapper = $this->createMock(FileGetContentsWrapper::class);
        $wrapper->method('file_get_contents')->willReturn($expected);

        $downloader = new FileGetContentsDownloader;
        $downloader->setWrapper($wrapper);
        $downloader->setLength($length);

        $this->assertSame(
            expected: $expected,
            actual: $downloader->download('https://localhost'),
        );

        $this->assertSame(
            expected: $length,
            actual: strlen($expected),
        );

        $this->assertStringStartsWith(
            prefix: $expected,
            string: $input,
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
