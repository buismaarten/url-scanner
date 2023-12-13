<?php

declare(strict_types=1);

namespace Buismaarten\UrlScanner\Detectors;

final class RegexDetector extends AbstractDetector
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
        if (preg_match_all('/"(https?:\\\\\/\\\\\/[^"]+)"/', $this->content, $matches, PREG_SET_ORDER)) {
            foreach ($matches as $match) {
                yield stripslashes($match[1]);
            }
        }
    }
}
