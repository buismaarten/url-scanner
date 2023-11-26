<?php

namespace Buismaarten\UrlScanner\Detectors;

use Buismaarten\UrlScanner\Detectors\AbstractUrlDetector;

final class SymfonyUrlDetector extends AbstractUrlDetector
{
    public function detect(string $url): array
    {
        return [];
    }
}
