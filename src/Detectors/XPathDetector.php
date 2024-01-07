<?php

declare(strict_types=1);

namespace Buismaarten\UrlScanner\Detectors;

use Buismaarten\UrlScanner\Interfaces\DetectorInterface;
use Symfony\Component\DomCrawler\Crawler;

class XPathDetector implements DetectorInterface
{
    /** @return iterable<string> */
    public function detect(string $url, string $content): iterable
    {
        $crawler = new Crawler($content, $url);

        foreach (self::getExpressions() as $query => $attribute) {
            yield from $crawler->filterXPath($query)->each(fn (Crawler $node) => trim($node->attr($attribute) ?? ''));
        }
    }

    /** @return array<string, string> */
    private static function getExpressions(): array
    {
        return [
            '//a[not(@rel) or @rel=""][@href]' => 'href',
            '//a[not(@rel) or @rel=""][@ping]' => 'ping',
            '//a[not(contains(@rel,"nofollow"))][@href]' => 'href',
            '//a[not(contains(@rel,"nofollow"))][@ping]' => 'ping',
            '//audio[@src]' => 'src',
            '//base[@href]' => 'href',
            '//form[not(@method) or @method=""][@action]' => 'action',
            '//form[not(@method) or @method=""]//button[@formaction]' => 'formaction',
            '//form[not(@method) or @method=""]//input[@formaction]' => 'formaction',
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
            '//svg//*[@href]' => 'href',
            '//svg//*[attribute::*[contains(local-name(),"xlink:href")]]' => 'xlink:href',
            '//track[@src]' => 'src',
            '//video[@poster]' => 'poster',
            '//video[@src]' => 'src',
        ];
    }
}
