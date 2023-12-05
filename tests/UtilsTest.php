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
            ['https://localhost/test', ['/test', 'https://localhost/']],

            // Absolute
            ['https://localhost', ['https://localhost/', null]],
            ['https://localhost/test', ['https://localhost/test/', null]],

            // Invalid
            [null, ['://localhost', null]],
        ];
    }
}
