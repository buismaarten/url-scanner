<?php

namespace Buismaarten\UrlScanner\Traits;

use GuzzleHttp\Client;

trait HasClientTrait
{
    protected Client $client;

    public function setClient(?Client $client): void
    {
        if ($client === null) {
            $client = self::getDefaultClient();
        }

        $this->client = $client;
    }

    public function getClient(): Client
    {
        return $this->client;
    }

    private static function getDefaultClient(): Client
    {
        return new Client;
    }
}
