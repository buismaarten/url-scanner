<?php

declare(strict_types=1);

namespace Buismaarten\UrlScanner\Detectors;

use Symfony\Component\DomCrawler\Crawler;

final class SymfonyDetector extends AbstractDetector
{
    private string $content;

    public function __construct(string $url, string $content)
    {
        parent::__construct($url);

        $this->content = $content;
    }

    /** @return iterable<string> */
    public function detect(): iterable
    {
        $crawler = new Crawler($this->content, $this->getUrl());

        foreach (self::getFilters() as $query => $attribute) {
            yield from $crawler->filterXPath($query)->each(fn (Crawler $node) => ($node->attr($attribute) ?? ''));
        }
    }

    /** @return array<string, string> */
    private static function getFilters(): array
    {
        return [
            '//a[@href]' => 'href',
            '//audio[@src]' => 'src',
            '//base[@href]' => 'href',
            '//form[not(@method)][@action]' => 'action',
            '//form[not(@method)]//button[@formaction]' => 'formaction',
            '//form[not(@method)]//input[@formaction]' => 'formaction',
            '//form[translate(@method,"abcdefghijklmnopqrstuvwxyz","ABCDEFGHIJKLMNOPQRSTUVWXYZ")="GET"][@action]' => 'action',
            '//form[translate(@method,"abcdefghijklmnopqrstuvwxyz","ABCDEFGHIJKLMNOPQRSTUVWXYZ")="GET"]//button[@formaction]' => 'formaction',
            '//form[translate(@method,"abcdefghijklmnopqrstuvwxyz","ABCDEFGHIJKLMNOPQRSTUVWXYZ")="GET"]//input[@formaction]' => 'formaction',
            '//iframe[@src]' => 'src',
            '//img[@src]' => 'src',
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
