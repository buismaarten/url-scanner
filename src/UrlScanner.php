<?php

namespace Buismaarten\UrlScanner;

use Buismaarten\UrlScanner\Detectors\AbstractUrlDetector;

final class UrlScanner
{
    private AbstractUrlDetector $detector;

    public function __construct(AbstractUrlDetector $detector)
    {
        $this->detector = $detector;
    }

    public function scan(string $url): array
    {
        return $this->detector->detect($url);
    }
}
