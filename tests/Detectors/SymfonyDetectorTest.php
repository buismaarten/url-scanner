<?php

declare(strict_types=1);

use Buismaarten\UrlScanner\Detectors\SymfonyDetector;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use League\Uri\Uri;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

// @todo
final class SymfonyDetectorTest extends TestCase
{
    #[DataProvider('providerDetect')]
    public function testDetect(array $results, Response $response): void
    {
        $client = new Client([
            'handler' => new MockHandler([$response]),
        ]);

        $detector = new SymfonyDetector;
        $detector->setClient($client);

        $this->assertSame($results, iterator_to_array($detector->detect(Uri::new())));
    }

    public static function providerDetect(): array
    {
        return [
            [
                'results' => ['/path'],
                'response' => new Response(
                    headers: ['Content-Type' => 'text/html'],
                    body: '<a href="/path">Link</a>',
                ),
            ],
            [
                'results' => ['/path/to/audio.mp3'],
                'response' => new Response(
                    headers: ['Content-Type' => 'text/html'],
                    body: '<audio src="/path/to/audio.mp3"></audio>',
                ),
            ],
            [
                'results' => ['/path'],
                'response' => new Response(
                    headers: ['Content-Type' => 'text/html'],
                    body: '<base href="/path">',
                ),
            ],
            [
                'results' => ['/path'],
                'response' => new Response(
                    headers: ['Content-Type' => 'text/html'],
                    body: '<button formaction="/path">Button</button>',
                ),
            ],
            [
                'results' => ['/path'],
                'response' => new Response(
                    headers: ['Content-Type' => 'text/html'],
                    body: '<form action="/path"></form>',
                ),
            ],
            [
                'results' => ['/path'],
                'response' => new Response(
                    headers: ['Content-Type' => 'text/html'],
                    body: '<iframe src="/path"></iframe>',
                ),
            ],
            [
                'results' => ['/path'],
                'response' => new Response(
                    headers: ['Content-Type' => 'text/html'],
                    body: '<img src="/path">',
                ),
            ],
            [
                'results' => ['/path'],
                'response' => new Response(
                    headers: ['Content-Type' => 'text/html'],
                    body: '<input formaction="/path">',
                ),
            ],
            [
                'results' => ['/path'],
                'response' => new Response(
                    headers: ['Content-Type' => 'text/html'],
                    body: '<input src="/path">',
                ),
            ],
            [
                'results' => ['/path'],
                'response' => new Response(
                    headers: ['Content-Type' => 'text/html'],
                    body: '<link href="/path">',
                ),
            ],
            [
                'results' => ['/path/to/image.png'],
                'response' => new Response(
                    headers: ['Content-Type' => 'text/html'],
                    body: '<meta name="msapplication-TileImage" content="/path/to/image.png">',
                ),
            ],
            [
                'results' => ['/path/to/image.png'],
                'response' => new Response(
                    headers: ['Content-Type' => 'text/html'],
                    body: '<meta name="twitter:image" content="/path/to/image.png">',
                ),
            ],
            [
                'results' => ['/path/to/audio.mp3'],
                'response' => new Response(
                    headers: ['Content-Type' => 'text/html'],
                    body: '<meta property="og:audio:secure_url" content="/path/to/audio.mp3">',
                ),
            ],
            [
                'results' => ['/path/to/audio.mp3'],
                'response' => new Response(
                    headers: ['Content-Type' => 'text/html'],
                    body: '<meta property="og:audio" content="/path/to/audio.mp3">',
                ),
            ],
            [
                'results' => ['/path/to/image.png'],
                'response' => new Response(
                    headers: ['Content-Type' => 'text/html'],
                    body: '<meta property="og:image:secure_url" content="/path/to/image.png">',
                ),
            ],
            [
                'results' => ['/path/to/image.png'],
                'response' => new Response(
                    headers: ['Content-Type' => 'text/html'],
                    body: '<meta property="og:image" content="/path/to/image.png">',
                ),
            ],
            [
                'results' => ['/path'],
                'response' => new Response(
                    headers: ['Content-Type' => 'text/html'],
                    body: '<meta property="og:url" content="/path">',
                ),
            ],
            [
                'results' => ['/path/to/video.mp4'],
                'response' => new Response(
                    headers: ['Content-Type' => 'text/html'],
                    body: '<meta property="og:video:secure_url" content="/path/to/video.mp4">',
                ),
            ],
            [
                'results' => ['/path/to/video.mp4'],
                'response' => new Response(
                    headers: ['Content-Type' => 'text/html'],
                    body: '<meta property="og:video" content="/path/to/video.mp4">',
                ),
            ],
            [
                'results' => ['/path/to/script.js'],
                'response' => new Response(
                    headers: ['Content-Type' => 'text/html'],
                    body: '<script src="/path/to/script.js"></script>',
                ),
            ],
            [
                'results' => ['/path/to/source.mp4'],
                'response' => new Response(
                    headers: ['Content-Type' => 'text/html'],
                    body: '<source src="/path/to/source.mp4">',
                ),
            ],
            [
                'results' => ['/path/to/track.vtt'],
                'response' => new Response(
                    headers: ['Content-Type' => 'text/html'],
                    body: '<track src="/path/to/track.vtt">',
                ),
            ],
            [
                'results' => ['/path/to/poster.png'],
                'response' => new Response(
                    headers: ['Content-Type' => 'text/html'],
                    body: '<video poster="/path/to/poster.png"></video>',
                ),
            ],
            [
                'results' => ['/path/to/video.mp4'],
                'response' => new Response(
                    headers: ['Content-Type' => 'text/html'],
                    body: '<video src="/path/to/video.mp4"></video>',
                ),
            ],

            // Invalid header "Content-Type"
            [
                'results' => [],
                'response' => new Response(
                    headers: ['Content-Type' => 'image/png'],
                    body: '<a href="/path">Link</a>',
                ),
            ],

            // Missing header "Content-Type"
            [
                'results' => [],
                'response' => new Response(
                    headers: [],
                    body: '<a href="/path">Link</a>',
                ),
            ],
        ];
    }
}
