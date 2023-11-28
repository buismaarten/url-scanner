<?php

namespace Buismaarten\UrlScanner\Contracts;

use Buismaarten\UrlScanner\Detectors\AbstractDetector;

interface HasDetector
{
    public function setDetector(?AbstractDetector $detector): void;
    public function getDetector(): AbstractDetector;
}
