<?php

declare(strict_types=1);

use Buismaarten\UrlScanner\Utils;
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

    #[DataProvider('providerNormalizeHost')]
    public function testNormalizeHost(string $expected, array $parameters): void
    {
        $this->assertSame($expected, Utils::normalizeHost($parameters[0]));
    }

    public static function providerNormalizeHost(): array
    {
        return [
            ['localhost', ['localhost']],
            ['localhost', ['www.localhost']],
        ];
    }
}
