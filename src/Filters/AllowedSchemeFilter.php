<?php

namespace Buismaarten\Crawler\Filters;

use League\Uri\Contracts\UriInterface;

class AllowedSchemeFilter extends AbstractFilter
{
    /** @var string[] */
    private readonly array $allowedSchemes;

    /**
     * @param string[] $allowedSchemes
     */
    public function __construct(array $allowedSchemes)
    {
        $this->allowedSchemes = $allowedSchemes;
    }

    public function match(UriInterface $url): bool
    {
        // @todo: implement filter
        return false;
    }
}
