<?php

namespace Buismaarten\UrlScanner\Traits;

use Buismaarten\UrlScanner\Contracts\HasClient;
use Buismaarten\UrlScanner\Detectors\AbstractDetector;
use Buismaarten\UrlScanner\Detectors\SymfonyDetector;

trait HasDetectorTrait
{
    use HasClientTrait;

    private ?AbstractDetector $detector = null;

    public function setDetector(AbstractDetector $detector): void
    {
        if ($detector instanceof HasClient && $detector->getClient() === null) {
            $detector->setClient($this->getClient());
        }

        $this->detector = $detector;
    }

    public function getDetector(): AbstractDetector
    {
        if ($this->detector === null) {
            $this->setDetector(static::getDefaultDetector());
        }

        return $this->detector;
    }

    private static function getDefaultDetector(): AbstractDetector
    {
        return new SymfonyDetector;
    }
}
