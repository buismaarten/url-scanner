<?php

class AllowedSchemeFilter extends AbstractFilter
{
    /** @var string[] */
    private array $allowedSchemes = [];

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
