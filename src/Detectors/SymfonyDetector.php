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
}
