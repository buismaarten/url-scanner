<?php

declare(strict_types=1);

namespace Buismaarten\UrlScanner\Detectors;

use League\Uri\Contracts\UriInterface;
use Symfony\Component\DomCrawler\Crawler;

final class SymfonyDetector extends AbstractDetector
{
    /** @var array<string, string> */
    private static $filters = [
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

    /** @return iterable<string> */
    public function detect(UriInterface $url): iterable
    {
        $response = $this->getClient()->get($url->toString());

        if (! str_starts_with($response->getHeaderLine('Content-Type'), 'text/html')) {
            return;
        }

        $content = $response->getBody()->getContents();
        $crawler = new Crawler($content, $url->toString());

        foreach (self::$filters as $query => $attribute) {
            yield from $crawler->filterXPath($query)->each(fn (Crawler $node) => ($node->attr($attribute) ?? ''));
        }
    }
}
