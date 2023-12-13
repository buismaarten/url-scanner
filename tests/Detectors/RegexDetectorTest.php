<?php

declare(strict_types=1);

use Buismaarten\UrlScanner\Detectors\RegexDetector;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class RegexDetectorTest extends TestCase
{
    #[DataProvider('detectEscapedUrlProvider')]
    #[DataProvider('detectCssUrlProvider')]
    public function testDetect(array $expected, string $content): void
    {
        $detector = new RegexDetector('https://localhost', $content);

        $this->assertSame(
            expected: $expected,
            actual: iterator_to_array($detector->detect()),
        );
    }

    public static function detectEscapedUrlProvider(): array
    {
        return [
            [
                'expected' => [
                    'https://localhost/path',
                ],
                'content' => '<script type="application/json">{"url":"https:\/\/localhost\/path"}</script>',
            ],
        ];
    }

    public static function detectCssUrlProvider(): array
    {
        return [
            [
                'expected' => [
                    'https://localhost/path/to/image.jpg',
                ],
                'content' => '<div style="background: url(https://localhost/path/to/image.jpg);"></div>',
            ],
            [
                'expected' => [
                    'https://localhost/path/to/image.jpg',
                ],
                'content' => '<div style="background: url(\'https://localhost/path/to/image.jpg\');"></div>',
            ],
            [
                'expected' => [
                    'https://localhost/path/to/image.jpg',
                ],
                'content' => "<div style='background: url(\"https://localhost/path/to/image.jpg\");'></div>",
            ],
        ];
    }
}
