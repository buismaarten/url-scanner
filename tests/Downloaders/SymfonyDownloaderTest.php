<?php

declare(strict_types=1);

use Buismaarten\UrlScanner\Downloaders\SymfonyDownloader;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\MockResponse;

// @todo
class SymfonyDownloaderTest extends TestCase
{
    public function test(): void
    {
        $expected = 'Hello World!';

        $client = new MockHttpClient;
        $client->setResponseFactory(new MockResponse($expected));

        $downloader = new SymfonyDownloader;
        $downloader->setClient($client);

        $this->assertSame(
            expected: $expected,
            actual: $downloader->download('https://localhost'),
        );
    }
}
