<?php

declare(strict_types=1);

use Buismaarten\UrlScanner\Downloaders\GuzzleDownloader;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class GuzzleDownloaderTest extends TestCase
{
    public function testResponse(): void
    {
        $handler = new MockHandler;
        $handler->append(new Response(body: 'Hello World!'));

        $client = new Client([
            'handler' => $handler,
        ]);

        $downloader = new GuzzleDownloader;
        $downloader->setClient($client);

        $this->assertSame(
            expected: 'Hello World!',
            actual: $downloader->download('https://localhost'),
        );
    }

    #[DataProvider('responseLengthProvider')]
    public function testResponseLength(string $expected, string $input, int $length): void
    {
        $handler = new MockHandler;
        $handler->append(new Response(body: $input));

        $client = new Client([
            'handler' => $handler,
        ]);

        $downloader = new GuzzleDownloader;
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
