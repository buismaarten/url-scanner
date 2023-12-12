<?php

declare(strict_types=1);

use Buismaarten\UrlScanner\Utils;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class UtilsTest extends TestCase
{
    #[DataProvider('normalizeUrlRelativeProvider')]
    #[DataProvider('normalizeUrlAbsoluteProvider')]
    #[DataProvider('normalizeUrlInvalidProvider')]
    public function testNormalizeUrl(?string $expected, array $url): void
    {
        $this->assertSame(
            expected: $expected,
            actual: Utils::normalizeUrl($url[0], $url[1])?->toString(),
        );
    }

    public static function normalizeUrlRelativeProvider(): array
    {
        return [
            [
                'expected' => 'https://localhost',
                'url' => ['/', 'https://localhost/'],
            ],
            [
                'expected' => 'https://localhost/path',
                'url' => ['/path', 'https://localhost/'],
            ],
            [
                'expected' => 'https://localhost/path?query=1',
                'url' => ['/path/?query=1', 'https://localhost/'],
            ],
            [
                'expected' => 'https://localhost/path?query=1',
                'url' => ['/path/?query=1#fragment', 'https://localhost/'],
            ],
        ];
    }

    public static function normalizeUrlAbsoluteProvider(): array
    {
        return [
            [
                'expected' => 'https://localhost',
                'url' => ['https://localhost/', null],
            ],
            [
                'expected' => 'https://localhost/path?query=1',
                'url' => ['https://localhost/path/?query=1', null],
            ],
            [
                'expected' => 'https://localhost/path?query=1',
                'url' => ['https://localhost/path/?query=1#fragment', null],
            ],
        ];
    }

    public static function normalizeUrlInvalidProvider(): array
    {
        return [
            [
                'expected' => null,
                'url' => ['://localhost', null],
            ],
        ];
    }

    #[DataProvider('normalizeHostProvider')]
    public function testNormalizeHost(string $expected, string $host): void
    {
        $this->assertSame(
            expected: $expected,
            actual: Utils::normalizeHost($host),
        );
    }

    public static function normalizeHostProvider(): array
    {
        return [
            ['localhost', 'localhost'],
            ['localhost', 'www.localhost'],
        ];
    }
}
