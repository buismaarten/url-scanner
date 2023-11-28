<?php

namespace Buismaarten\UrlScanner\Traits;

use Buismaarten\UrlScanner\Contracts\HasClient;
use Buismaarten\UrlScanner\Detectors\AbstractDetector;
use Buismaarten\UrlScanner\Detectors\SymfonyDetector;

trait HasDetectorTrait
{
    use HasClientTrait;

    protected AbstractDetector $detector;

    public function setDetector(?AbstractDetector $detector): void
    {
        if ($detector === null) {
            $detector = new SymfonyDetector;
        }

        if ($detector instanceof HasClient) {
            $detector->setClient($this->getClient());
        }

        $this->detector = $detector;
    }

    public function getDetector(): AbstractDetector
    {
        return $this->detector;
    }
}
