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
            '//audio[@src]' => 'src',
            '//base[@href]' => 'href',
            '//button[@formaction]' => 'formaction',
            '//form[@action]' => 'action',
            '//iframe[@src]' => 'src',
            '//img[@src]' => 'src',
            '//input[@formaction]' => 'formaction',
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
            '//source[@src]' => 'src',
            '//track[@src]' => 'src',
            '//video[@poster]' => 'poster',
            '//video[@src]' => 'src',
        ];
    }
}
