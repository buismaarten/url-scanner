<?php

namespace Buismaarten\UrlScanner\Traits;

// @todo
trait HasClientTrait
{
    protected object $client;

    public function setClient(?object $client): void
    {
        if ($client === null) {
            $client = self::getDefaultClient();
        }

        $this->client = $client;
    }

    public function getClient(): object
    {
        return $this->client;
    }

    private static function getDefaultClient(): object
    {
        return new \stdClass;
    }
}
