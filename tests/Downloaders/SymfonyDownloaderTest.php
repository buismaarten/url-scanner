<?php

declare(strict_types=1);

use Buismaarten\UrlScanner\Downloaders\SymfonyDownloader;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\MockResponse;

class SymfonyDownloaderTest extends TestCase
{
    #[DataProvider('responseProvider')]
    public function testResponse(string $expected, mixed $value): void
    {
        $client = new MockHttpClient;
        $client->setResponseFactory(new MockResponse($value));

        $downloader = new SymfonyDownloader;
        $downloader->setClient($client);

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
        $client = new MockHttpClient;
        $client->setResponseFactory(new MockResponse($input));

        $downloader = new SymfonyDownloader;
        $downloader->setClient($client);
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
