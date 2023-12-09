<?php

declare(strict_types=1);

use Buismaarten\UrlScanner\Utils;
use League\Uri\Uri;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class UtilsTest extends TestCase
{
    #[DataProvider('providerNormalizeUrl')]
    public function testNormalizeUrl(?string $expected, array $parameters): void
    {
        $this->assertSame($expected, Utils::normalizeUrl($parameters[0], $parameters[1])?->toString());
    }

    public static function providerNormalizeUrl(): array
    {
        return [
            // Relative
            ['https://localhost', ['/', 'https://localhost/']],
            ['https://localhost/path', ['/path', 'https://localhost/']],
            ['https://localhost/path?query=1', ['/path/?query=1', 'https://localhost/']],
            ['https://localhost/path?query=1', ['/path/?query=1#fragment', 'https://localhost/']],

            // Absolute
            ['https://localhost', ['https://localhost/', null]],
            ['https://localhost/path?query=1', ['https://localhost/path/?query=1', null]],
            ['https://localhost/path?query=1', ['https://localhost/path/?query=1#fragment', null]],

            // Invalid
            [null, ['://localhost', null]],
        ];
    }

    #[DataProvider('providerValidateUrl')]
    public function testValidateUrl(bool $expected, string $url): void
    {
        $this->assertSame($expected, Utils::validateUrl(Uri::new($url)));
    }

    public static function providerValidateUrl(): array
    {
        return [
            // Valid
            [true, 'http://localhost'],
            [true, 'https://localhost'],

            // Invalid
            [false, 'data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmci'],
            [false, 'mailto:root@localhost'],
            [false, 'tel:1234567890'],
        ];
    }

    #[DataProvider('providerNormalizeHost')]
    public function testNormalizeHost(string $expected, string $host): void
    {
        $this->assertSame($expected, Utils::normalizeHost($host));
    }

    public static function providerNormalizeHost(): array
    {
        return [
            ['localhost', 'localhost'],
            ['localhost', 'www.localhost'],
        ];
    }
}
