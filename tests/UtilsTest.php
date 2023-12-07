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
            ['https://domain.com/path', ['/path/#fragment', 'https://domain.com/']],

            // Absolute
            ['https://domain.com', ['https://domain.com/', null]],
            ['https://domain.com/path', ['https://domain.com/path/', null]],
            ['https://domain.com/path', ['https://domain.com/path/#fragment', null]],

            // Invalid
            [null, ['://domain.com', null]],
        ];
    }
}
