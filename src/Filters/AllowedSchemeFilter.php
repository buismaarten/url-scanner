<?php

namespace Buismaarten\Crawler\Filters;

class AllowedSchemeFilter extends AbstractFilter
{
    /** @var string[] */
    private readonly array $allowedSchemes;

    public function __construct(array $allowedSchemes)
    {
        $this->allowedSchemes = $allowedSchemes;
    }

    public function match(string $url): bool
    {
        // @todo: implement filter
        return false;
    }
}
