<?php

namespace Buismaarten\UrlScanner\Detectors;

use League\Uri\Contracts\UriInterface;

final class SymfonyDetector extends AbstractDetector
{
    /** @return UriInterface[] */
    public function detect(UriInterface $url): array
    {
        return [];
    }

    /** @return array<string, string> */
    private static function getFilters(): array
    {
        return [
            '//a[@href]' => 'href',
            '//base[@href]' => 'href',
            '//form[@action]' => 'action',
            '//iframe[@src]' => 'src',
            '//input[@src]' => 'src',
            '//link[@href]' => 'href',
            '//meta[@name="msapplication-TileImage"][@content]' => 'content',
            '//meta[@name="twitter:image"][@content]' => 'content',
            '//meta[@property="og:audio:secure_url"][@content]' => 'content',
            '//meta[@property="og:audio"][@content]' => 'content',
            '//meta[@property="og:image:secure_url"][@content]' => 'content',
            '//meta[@property="og:image"][@content]' => 'content',
            '//meta[@property="og:url"][@content]' => 'content',
            '//meta[@property="og:video:secure_url"][@content]' => 'content',
            '//meta[@property="og:video"][@content]' => 'content',
            '//script[@src]' => 'src',
        ];
    }
}
