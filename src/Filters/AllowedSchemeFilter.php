<?php

class AllowedSchemeFilter extends AbstractFilter
{
    private array $allowedSchemes = [];

    public function __construct(array $allowedSchemes = [])
    {
        $this->allowedSchemes = $allowedSchemes;
    }

    public function match(string $uri): bool
    {
        // @todo: implement filter
        return true;
    }
}
