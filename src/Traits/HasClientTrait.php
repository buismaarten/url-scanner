<?php

namespace Buismaarten\UrlScanner\Traits;

// @todo
trait HasClientTrait
{
    protected object $client;

    public function setClient(?object $client): void
    {
        if ($client === null) {
            $client = new \stdClass;
        }

        $this->client = $client;
    }

    public function getClient(): object
    {
        return $this->client;
    }
}
