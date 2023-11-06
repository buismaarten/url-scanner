<?php

namespace Buismaarten\Crawler\Filters;

abstract class AbstractFilter
{
    abstract public function match(string $url): bool;
}
