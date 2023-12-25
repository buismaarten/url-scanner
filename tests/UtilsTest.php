<?php

declare(strict_types=1);

use Buismaarten\UrlScanner\Utils;
use League\Uri\Uri;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class UtilsTest extends TestCase
{
    #[DataProvider('validateUrlProvider')]
    public function testValidateUrl(bool $expected, string $url): void
    {
        $this->assertSame(
            expected: $expected,
            actual: Utils::validateUrl($url),
        );

        $this->assertSame(
            expected: $expected,
            actual: Utils::validateUrl(Uri::new($url)),
        );
    }

    public static function validateUrlProvider(): array
    {
        return [
            [
                'expected' => true,
                'url' => 'https://localhost',
            ],
            [
                'expected' => true,
                'url' => 'http://localhost',
            ],
            [
                'expected' => false,
                'url' => 'mailto:root@localhost',
            ],
            [
                'expected' => false,
                'url' => 'tel:+31612345678',
            ],
            [
                'expected' => false,
                'url' => 'data:text/plain;base64,SGVsbG8sIFdvcmxkIQ==',
            ],
        ];
    }

    #[DataProvider('normalizeUrlRelativeProvider')]
    #[DataProvider('normalizeUrlAbsoluteProvider')]
    #[DataProvider('normalizeUrlInvalidCredentialsProvider')]
    #[DataProvider('normalizeUrlInvalidSchemeProvider')]
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
                'expected' => 'https://localhost/path',
                'url' => ['https://localhost/path/', null],
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

    public static function normalizeUrlInvalidCredentialsProvider(): array
    {
        return [
            [
                'expected' => 'https://localhost',
                'url' => ['https://user@localhost', null],
            ],
        ];
    }

    public static function normalizeUrlInvalidSchemeProvider(): array
    {
        return [
            [
                'expected' => null,
                'url' => ['://localhost', null],
            ],
        ];
    }

    #[DataProvider('validateHostProvider')]
    public function testValidateHost(bool $expected, string $host): void
    {
        $this->assertSame(
            expected: $expected,
            actual: Utils::validateHost($host),
        );
    }

    public static function validateHostProvider(): array
    {
        return [
            [
                'expected' => true,
                'url' => 'localhost',
            ],
            [
                'expected' => true,
                'url' => 'www.localhost',
            ],
            [
                'expected' => false,
                'url' => '127.0.0.1',
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
            [
                'expected' => 'localhost',
                'url' => 'localhost',
            ],
            [
                'expected' => 'localhost',
                'url' => 'www.localhost',
            ],
        ];
    }
}
