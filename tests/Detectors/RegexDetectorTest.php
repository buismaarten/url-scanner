<?php

declare(strict_types=1);

use Buismaarten\UrlScanner\Detectors\RegexDetector;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class RegexDetectorTest extends TestCase
{
    #[DataProvider('detectCssUrlProvider')]
    #[DataProvider('detectCssImportProvider')]
    #[DataProvider('detectScriptNormalUrlProvider')]
    #[DataProvider('detectScriptEscapedUrlProvider')]
    public function testDetect(array $expected, string $content): void
    {
        $detector = new RegexDetector;

        $this->assertSame(
            expected: $expected,
            actual: iterator_to_array($detector->detect('https://localhost', $content)),
        );
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

    public static function detectCssImportProvider(): array
    {
        return [
            [
                'expected' => [
                    'https://localhost/path/to/stylesheet.css',
                ],
                'content' => '@import "https://localhost/path/to/stylesheet.css"',
            ],
            [
                'expected' => [
                    'https://localhost/path/to/stylesheet.css',
                ],
                'content' => "@import 'https://localhost/path/to/stylesheet.css'",
            ],
        ];
    }

    public static function detectScriptNormalUrlProvider(): array
    {
        return [
            [
                'expected' => [
                    'https://localhost/path',
                    'http://localhost/path',
                ],
                'content' => '<script type="text/javascript">const a = {"url1":"https://localhost/path","url2":"http://localhost/path"};</script>',
            ],
            [
                'expected' => [
                    'https://schema.org',
                    'https://localhost/path',
                    'http://localhost/path',
                ],
                'content' => '<script type="application/ld+json">{"@context":"https://schema.org","url1":"https://localhost/path","url2":"http://localhost/path"}</script>',
            ],
        ];
    }

    public static function detectScriptEscapedUrlProvider(): array
    {
        return [
            [
                'expected' => [
                    'https://localhost/path',
                    'http://localhost/path',
                ],
                'content' => '<script type="text/javascript">const a = {"url1":"https:\/\/localhost\/path","url2":"http:\/\/localhost\/path"};</script>',
            ],
            [
                'expected' => [
                    'https://schema.org',
                    'https://localhost/path',
                    'http://localhost/path',
                ],
                'content' => '<script type="application/ld+json">{"@context":"https:\/\/schema.org","url1":"https:\/\/localhost\/path","url2":"http:\/\/localhost\/path"}</script>',
            ],
        ];
    }

    public function testDetectNoResults(): void
    {
        $detector = new RegexDetector;

        $this->assertSame(
            expected: [],
            actual: iterator_to_array($detector->detect('https://localhost', '')),
        );
    }
}
