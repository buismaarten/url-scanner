<?php

declare(strict_types=1);

use Buismaarten\UrlScanner\UrlScannerResult;
use Buismaarten\UrlScanner\Utils;
use League\Uri\Uri;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class UrlScannerResultTest extends TestCase
{
    #[DataProvider('getHostsProvider')]
    public function testGetHosts(array $expected, array $urls): void
    {
        $result = new UrlScannerResult($urls);

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
                    'https://localhost' => Utils::normalizeUrl('https://localhost', null),
                ],
            ],
        ];
    }

    #[DataProvider('getUrlsProvider')]
    public function testGetUrls(array $expected, array $urls): void
    {
        $result = new UrlScannerResult($urls);

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
                ],
                'urls' => [
                    'https://localhost' => Utils::normalizeUrl('https://localhost', null),
                    'https://localhost' => Utils::normalizeUrl('https://localhost', null),
                ],
            ],
        ];
    }
}
