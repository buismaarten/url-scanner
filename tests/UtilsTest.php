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
            ['https://domain.com', ['/', 'https://domain.com/']],
            ['https://domain.com/path', ['/path', 'https://domain.com/']],
            ['https://domain.com/path?query=1', ['/path/?query=1', 'https://domain.com/']],
            ['https://domain.com/path?query=1', ['/path/?query=1#fragment', 'https://domain.com/']],

            // Absolute
            ['https://domain.com', ['https://domain.com/', null]],
            ['https://domain.com/path?query=1', ['https://domain.com/path/?query=1', null]],
            ['https://domain.com/path?query=1', ['https://domain.com/path/?query=1#fragment', null]],

            // Invalid
            [null, ['://domain.com', null]],
        ];
    }
}
