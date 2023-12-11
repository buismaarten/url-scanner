<?php

declare(strict_types=1);

use Buismaarten\UrlScanner\Detectors\SymfonyDetector;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

// @todo
final class SymfonyDetectorTest extends TestCase
{
    #[DataProvider('providerDetect')]
    public function testDetect(string $content, array $expected): void
    {
        $detector = new SymfonyDetector('https://localhost', $content);

        $this->assertSame(
            expected: $expected,
            actual: iterator_to_array($detector->detect()),
        );
    }

    public static function providerDetect(): array
    {
        return [
            [
                'content' => '<a href="/path">Link</a>',
                'expected' => [
                    '/path',
                ],
            ],
        ];
    }
}
