<?php

abstract class AbstractFilter
{
    abstract public function match(string $uri): bool;
}
