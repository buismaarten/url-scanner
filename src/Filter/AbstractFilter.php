<?php

namespace Buismaarten\Crawler\Filter;

use League\Uri\Contracts\UriInterface;

abstract class AbstractFilter
{
    abstract public function match(UriInterface $url): bool;
}
