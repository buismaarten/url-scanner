<?php

declare(strict_types=1);

namespace Buismaarten\UrlScanner\Detectors;

use Buismaarten\UrlScanner\Interfaces\DetectorInterface;

class RegexDetector implements DetectorInterface
{
    /** @return iterable<string> */
    public function detect(string $url, string $content): iterable
    {
        if (preg_match_all('/url\(([^)]+)\)/i', $content, $matches, PREG_SET_ORDER)) {
            foreach ($matches as $match) {
                $value = $match[1];
                $value = preg_replace('/^[\'"]+|[\'"]+$/i', '', $value);

                if (is_string($value) && ! empty($value)) {
                    yield trim($value);
                }
            }
        }

        if (preg_match_all('/@import\s+(?:\'|")(https?:\/\/[^\'"]+)(?:\'|")/i', $content, $matches, PREG_SET_ORDER)) {
            foreach ($matches as $match) {
                $value = $match[1];

                if (is_string($value) && ! empty($value)) {
                    yield trim($value);
                }
            }
        }

        if (preg_match_all('/<script\b[^>]*>(.*?)<\/script>/is', $content, $matches, PREG_SET_ORDER)) {
            $code = '';

            foreach ($matches as $match) {
                $code .= $match[1];
            }

            if (preg_match_all('/"(https?:\/\/[^"]+)"/i', $code, $matches, PREG_SET_ORDER)) {
                foreach ($matches as $match) {
                    $value = $match[1];

                    if (is_string($value) && ! empty($value)) {
                        yield trim($value);
                    }
                }
            }

            if (preg_match_all('/"(https?:\\\\\/\\\\\/[^"]+)"/i', $code, $matches, PREG_SET_ORDER)) {
                foreach ($matches as $match) {
                    $value = $match[1];
                    $value = stripslashes($value);

                    if (is_string($value) && ! empty($value)) {
                        yield trim($value);
                    }
                }
            }
        }
    }
}
