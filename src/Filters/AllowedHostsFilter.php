<?php

class AllowedHostsFilter extends AbstractFilter
{
    /** @var string[] */
    private array $allowedHosts = [];

    public function __construct(array $allowedHosts = [])
    {
        $this->allowedHosts = $allowedHosts;
    }

    public function match(string $url): bool
    {
        // @todo: implement filter
        return false;
    }
}
