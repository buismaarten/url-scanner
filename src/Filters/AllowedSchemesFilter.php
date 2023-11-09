<?php

namespace Buismaarten\Crawler\Filters;

use League\Uri\Contracts\UriInterface;

class AllowedSchemesFilter extends AbstractFilter
{
    private readonly array $allowedSchemes;

    public function __construct(array $allowedSchemes)
    {
        $this->allowedSchemes = $allowedSchemes;
    }

    public function match(UriInterface $url): bool
    {
        return (! in_array($url->getScheme(), $this->allowedSchemes));
    }
}
