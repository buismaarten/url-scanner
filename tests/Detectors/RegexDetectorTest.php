<?php

declare(strict_types=1);

use Buismaarten\UrlScanner\Detectors\RegexDetector;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class RegexDetectorTest extends TestCase
{
    #[DataProvider('detectProvider')]
    public function testDetect(array $expected, string $content): void
    {
        $detector = new RegexDetector('https://localhost', $content);

        $this->assertSame(
            expected: $expected,
            actual: iterator_to_array($detector->detect()),
        );
    }

    public static function detectProvider(): array
    {
        return [
            [
                'expected' => [
                    'https://localhost/path',
                ],
                'content' => '<script type="application/javascript">{"url":"https:\/\/localhost\/path"}</script>',
            ],
        ];
    }
}
