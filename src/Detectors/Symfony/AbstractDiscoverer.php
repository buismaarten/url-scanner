<?php

namespace Buismaarten\UrlScanner\Detectors\Symfony;

abstract class AbstractDiscoverer
{
    abstract public function discover(): array;
}
