<?php

declare(strict_types=1);

use Buismaarten\UrlScanner\Detectors\RegexDetector;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class RegexDetectorTest extends TestCase
{
    #[DataProvider('detectEscapedUrlProvider')]
    #[DataProvider('detectCssUrlProvider')]
    #[DataProvider('detectCommentUrlProvider')]
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
                    'http://localhost/path',
                ],
                'content' => '<script type="application/json">{"url1":"https:\/\/localhost\/path","url2":"http:\/\/localhost\/path"}</script>',
            ],
        ];
    }

    public static function detectCssUrlProvider(): array
    {
        return [
            [
                'expected' => [
                    'https://localhost/path/to/image.jpg',
                    'http://localhost/path/to/image.jpg',
                ],
                'content' => '<div style="background:url(https://localhost/path/to/image.jpg);"></div><div style="background:url(http://localhost/path/to/image.jpg);"></div>',
            ],
            [
                'expected' => [
                    'https://localhost/path/to/image.jpg',
                    'http://localhost/path/to/image.jpg',
                ],
                'content' => '<div style="background:url(\'https://localhost/path/to/image.jpg\');"></div><div style="background:url(\'http://localhost/path/to/image.jpg\');"></div>',
            ],
            [
                'expected' => [
                    'https://localhost/path/to/image.jpg',
                    'http://localhost/path/to/image.jpg',
                ],
                'content' => "<div style='background:url(\"https://localhost/path/to/image.jpg\");'></div><div style='background:url(\"http://localhost/path/to/image.jpg\");'></div>",
            ],
        ];
    }

    public static function detectCommentUrlProvider(): array
    {
        return [
            [
                'expected' => [
                    'https://localhost/path',
                ],
                'content' => '<!-- URL: https://localhost/path -->',
            ],
            [
                'expected' => [
                    'http://localhost/path',
                ],
                'content' => '<!-- URL: http://localhost/path -->',
            ],
        ];
    }
}
