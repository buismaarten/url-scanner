<?php

namespace Buismaarten\UrlScanner\Detectors;

abstract class AbstractUrlDetector
{
    abstract public function detect(): array;
}
