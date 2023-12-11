<?php

declare(strict_types=1);

use Buismaarten\UrlScanner\Detectors\SymfonyDetector;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

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
            [
                'content' => '<audio src="/path/to/audio.mp3"></audio>',
                'expected' => [
                    '/path/to/audio.mp3',
                ],
            ],
            [
                'content' => '<base href="/path"></base>',
                'expected' => [
                    '/path',
                ],
            ],

            // @todo: add tests for forms

            [
                'content' => '<iframe src="/path"></iframe>',
                'expected' => [
                    '/path',
                ],
            ],
            [
                'content' => '<img src="/path/to/image.jpg">',
                'expected' => [
                    '/path/to/image.jpg',
                ],
            ],
            [
                'content' => '<input src="/path/to/image.jpg">',
                'expected' => [
                    '/path/to/image.jpg',
                ],
            ],
            [
                'content' => '<link rel="stylesheet" href="/path/to/stylesheet.css">',
                'expected' => [
                    '/path/to/stylesheet.css',
                ],
            ],
            [
                'content' => '<meta name="msapplication-TileImage" content="/path/to/image.jpg">',
                'expected' => [
                    '/path/to/image.jpg',
                ],
            ],
            [
                'content' => '<meta name="twitter:image" content="/path/to/image.jpg">',
                'expected' => [
                    '/path/to/image.jpg',
                ],
            ],
            [
                'content' => '<meta property="og:audio:secure_url" content="/path/to/audio.mp3">',
                'expected' => [
                    '/path/to/audio.mp3',
                ],
            ],
            [
                'content' => '<meta property="og:audio" content="/path/to/audio.mp3">',
                'expected' => [
                    '/path/to/audio.mp3',
                ],
            ],
            [
                'content' => '<meta property="og:image:secure_url" content="/path/to/image.jpg">',
                'expected' => [
                    '/path/to/image.jpg',
                ],
            ],
            [
                'content' => '<meta property="og:image" content="/path/to/image.jpg">',
                'expected' => [
                    '/path/to/image.jpg',
                ],
            ],
            [
                'content' => '<meta property="og:url" content="/page">',
                'expected' => [
                    '/page',
                ],
            ],
            [
                'content' => '<meta property="og:video:secure_url" content="/path/to/video.mp4">',
                'expected' => [
                    '/path/to/video.mp4',
                ],
            ],
            [
                'content' => '<meta property="og:video" content="/path/to/video.mp4">',
                'expected' => [
                    '/path/to/video.mp4',
                ],
            ],
            [
                'content' => '<script src="/path/to/script.js"></script>',
                'expected' => [
                    '/path/to/script.js',
                ],
            ],
            [
                'content' => '<source src="/path/to/video.mp4">',
                'expected' => [
                    '/path/to/video.mp4',
                ],
            ],
            [
                'content' => '<track src="/path/to/track.vtt">',
                'expected' => [
                    '/path/to/track.vtt',
                ],
            ],
            [
                'content' => '<video poster="/path/to/poster.jpg"></video>',
                'expected' => [
                    '/path/to/poster.jpg',
                ],
            ],
            [
                'content' => '<video src="/path/to/video.mp4"></video>',
                'expected' => [
                    '/path/to/video.mp4',
                ],
            ],
        ];
    }
}
