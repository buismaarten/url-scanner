<?php

abstract class AbstractFilter
{
    abstract public function match(string $url): bool;
}
