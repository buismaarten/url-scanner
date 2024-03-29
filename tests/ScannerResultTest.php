<?php

declare(strict_types=1);

use Buismaarten\UrlScanner\ScannerResult;
use Buismaarten\UrlScanner\Utils;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class ScannerResultTest extends TestCase
{
    #[DataProvider('getHostsProvider')]
    public function testGetHosts(array $expected, array $urls): void
    {
        $result = new ScannerResult($urls);

        $this->assertSame(
            expected: $expected,
            actual: $result->getHosts(),
        );
    }

    public static function getHostsProvider(): array
    {
        return [
            [
                'expected' => [
                    'localhost',
                ],
                'urls' => [
                    'https://localhost' => Utils::normalizeUrl('https://localhost', null),
                    'http://127.0.0.1' => Utils::normalizeUrl('http://127.0.0.1', null),
                    'https://localhost' => Utils::normalizeUrl('https://localhost', null),
                    'http://127.0.0.1' => Utils::normalizeUrl('http://127.0.0.1', null),
                ],
            ],
            [
                'expected' => [],
                'urls' => [],
            ],
        ];
    }

    #[DataProvider('getUrlsProvider')]
    public function testGetUrls(array $expected, array $urls): void
    {
        $result = new ScannerResult($urls);

        $this->assertSame(
            expected: $expected,
            actual: $result->getUrls(),
        );
    }

    public static function getUrlsProvider(): array
    {
        return [
            [
                'expected' => [
                    'https://localhost',
                    'http://127.0.0.1',
                ],
                'urls' => [
                    'https://localhost' => Utils::normalizeUrl('https://localhost', null),
                    'http://127.0.0.1' => Utils::normalizeUrl('http://127.0.0.1', null),
                    'https://localhost/#fragment' => Utils::normalizeUrl('https://localhost/#fragment', null),
                    'http://127.0.0.1/#fragment' => Utils::normalizeUrl('http://127.0.0.1/#fragment', null),
                ],
            ],
            [
                'expected' => [],
                'urls' => [],
            ],
        ];
    }
}
