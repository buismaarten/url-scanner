<?php

declare(strict_types=1);

namespace Buismaarten\UrlScanner\Detectors;

abstract class AbstractDetector
{
    /** @return iterable<string> */
    abstract public function detect(string $url, string $content): iterable;
}
