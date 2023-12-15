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
                $value = $match[1];
                $value = stripslashes($value);

                if (is_string($value) && ! empty($value)) {
                    yield trim($value);
                }
            }
        }

        if (preg_match_all('/url\(([^)]+)\)/', $this->content, $matches, PREG_SET_ORDER)) {
            foreach ($matches as $match) {
                $value = $match[1];
                $value = preg_replace('/^[\'"]+|[\'"]+$/', '', $value);

                if (is_string($value) && ! empty($value)) {
                    yield trim($value);
                }
            }
        }

        if (preg_match_all('/@import\s+(?:\'|")(https?:\/\/[^\'"]+)(?:\'|")/', $this->content, $matches, PREG_SET_ORDER)) {
            foreach ($matches as $match) {
                $value = $match[1];

                if (is_string($value) && ! empty($value)) {
                    yield trim($value);
                }
            }
        }
    }
}
