<?php

declare(strict_types=1);

namespace Buismaarten\UrlScanner\Detectors;

use Buismaarten\UrlScanner\Interfaces\DetectorInterface;

final class RegexDetector implements DetectorInterface
{
    /** @return iterable<string> */
    public function detect(string $url, string $content): iterable
    {
        if (preg_match_all('/"(https?:\\\\\/\\\\\/[^"]+)"/', $content, $matches, PREG_SET_ORDER)) {
            foreach ($matches as $match) {
                $value = $match[1];
                $value = stripslashes($value);

                if (is_string($value) && ! empty($value)) {
                    yield trim($value);
                }
            }
        }

        if (preg_match_all('/url\(([^)]+)\)/', $content, $matches, PREG_SET_ORDER)) {
            foreach ($matches as $match) {
                $value = $match[1];
                $value = preg_replace('/^[\'"]+|[\'"]+$/', '', $value);

                if (is_string($value) && ! empty($value)) {
                    yield trim($value);
                }
            }
        }

        if (preg_match_all('/@import\s+(?:\'|")(https?:\/\/[^\'"]+)(?:\'|")/', $content, $matches, PREG_SET_ORDER)) {
            foreach ($matches as $match) {
                $value = $match[1];

                if (is_string($value) && ! empty($value)) {
                    yield trim($value);
                }
            }
        }
    }
}
