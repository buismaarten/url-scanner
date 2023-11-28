<?php

namespace Buismaarten\UrlScanner\Contracts;

// @todo
interface HasClient
{
    public function setClient(object $client): void;
    public function getClient(): object;
}
