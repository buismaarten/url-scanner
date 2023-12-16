<?php

declare(strict_types=1);

namespace Buismaarten\UrlScanner\Interfaces;

interface DetectorInterface
{
    /** @return iterable<string> */
    public function detect(string $url, string $content): iterable;
}
