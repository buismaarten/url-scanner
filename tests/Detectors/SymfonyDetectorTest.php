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
                'content' => '<a href="https://localhost/path">Link</a>',
                'expected' => [
                    'https://localhost/path',
                ],
            ],
            [
                'content' => '<audio src="https://localhost/path/to/audio.mp3"></audio>',
                'expected' => [
                    'https://localhost/path/to/audio.mp3',
                ],
            ],
            [
                'content' => '<base href="https://localhost/path"></base>',
                'expected' => [
                    'https://localhost/path',
                ],
            ],
            [
                'content' => '<form action="https://localhost/path"></form><form action="https://localhost/path" method=""></form>',
                'expected' => [
                    'https://localhost/path',
                    'https://localhost/path',
                ],
            ],
            [
                'content' => '<form><button formaction="https://localhost/path"></button></form><form method=""><button formaction="https://localhost/path"></button></form>',
                'expected' => [
                    'https://localhost/path',
                    'https://localhost/path',
                ],
            ],
            [
                'content' => '<form><input formaction="https://localhost/path"></form><form method=""><input formaction="https://localhost/path"></form>',
                'expected' => [
                    'https://localhost/path',
                    'https://localhost/path',
                ],
            ],
            [
                'content' => '<form action="https://localhost/path" method="get"></form><form action="https://localhost/path" method="post"></form>',
                'expected' => [
                    'https://localhost/path',
                ],
            ],
            [
                'content' => '<form method="get"><button formaction="https://localhost/path"></button></form><form method="post"><button formaction="https://localhost/path"></button></form>',
                'expected' => [
                    'https://localhost/path',
                ],
            ],
            [
                'content' => '<form method="get"><input formaction="https://localhost/path"></form><form method="post"><input formaction="https://localhost/path"></form>',
                'expected' => [
                    'https://localhost/path',
                ],
            ],
            [
                'content' => '<iframe src="https://localhost/path"></iframe>',
                'expected' => [
                    'https://localhost/path',
                ],
            ],
            [
                'content' => '<img src="https://localhost/path/to/image.jpg">',
                'expected' => [
                    'https://localhost/path/to/image.jpg',
                ],
            ],
            [
                'content' => '<input src="https://localhost/path/to/image.jpg">',
                'expected' => [
                    'https://localhost/path/to/image.jpg',
                ],
            ],
            [
                'content' => '<link rel="stylesheet" href="https://localhost/path/to/stylesheet.css">',
                'expected' => [
                    'https://localhost/path/to/stylesheet.css',
                ],
            ],
            [
                'content' => '<meta name="msapplication-TileImage" content="https://localhost/path/to/image.jpg">',
                'expected' => [
                    'https://localhost/path/to/image.jpg',
                ],
            ],
            [
                'content' => '<meta name="twitter:image" content="https://localhost/path/to/image.jpg">',
                'expected' => [
                    'https://localhost/path/to/image.jpg',
                ],
            ],
            [
                'content' => '<meta property="og:audio:secure_url" content="https://localhost/path/to/audio.mp3">',
                'expected' => [
                    'https://localhost/path/to/audio.mp3',
                ],
            ],
            [
                'content' => '<meta property="og:audio" content="https://localhost/path/to/audio.mp3">',
                'expected' => [
                    'https://localhost/path/to/audio.mp3',
                ],
            ],
            [
                'content' => '<meta property="og:image:secure_url" content="https://localhost/path/to/image.jpg">',
                'expected' => [
                    'https://localhost/path/to/image.jpg',
                ],
            ],
            [
                'content' => '<meta property="og:image" content="https://localhost/path/to/image.jpg">',
                'expected' => [
                    'https://localhost/path/to/image.jpg',
                ],
            ],
            [
                'content' => '<meta property="og:url" content="/page">',
                'expected' => [
                    '/page',
                ],
            ],
            [
                'content' => '<meta property="og:video:secure_url" content="https://localhost/path/to/video.mp4">',
                'expected' => [
                    'https://localhost/path/to/video.mp4',
                ],
            ],
            [
                'content' => '<meta property="og:video" content="https://localhost/path/to/video.mp4">',
                'expected' => [
                    'https://localhost/path/to/video.mp4',
                ],
            ],
            [
                'content' => '<script src="https://localhost/path/to/script.js"></script>',
                'expected' => [
                    'https://localhost/path/to/script.js',
                ],
            ],
            [
                'content' => '<source src="https://localhost/path/to/video.mp4">',
                'expected' => [
                    'https://localhost/path/to/video.mp4',
                ],
            ],
            [
                'content' => '<track src="https://localhost/path/to/track.vtt">',
                'expected' => [
                    'https://localhost/path/to/track.vtt',
                ],
            ],
            [
                'content' => '<video poster="https://localhost/path/to/poster.jpg"></video>',
                'expected' => [
                    'https://localhost/path/to/poster.jpg',
                ],
            ],
            [
                'content' => '<video src="https://localhost/path/to/video.mp4"></video>',
                'expected' => [
                    'https://localhost/path/to/video.mp4',
                ],
            ],
        ];
    }
}
