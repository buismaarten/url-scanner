<?php

namespace Buismaarten\UrlScanner\Detectors\Symfony\Discoverers;

abstract class AbstractDiscoverer
{
    abstract public function discover(): array;
}
