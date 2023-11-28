<?php

namespace Buismaarten\UrlScanner\Traits;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

trait HasClientTrait
{
    private Client $client;

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
        return new Client([
            RequestOptions::ALLOW_REDIRECTS => true,
            RequestOptions::CONNECT_TIMEOUT => 30,
            RequestOptions::HTTP_ERRORS => false,
            RequestOptions::TIMEOUT => 30,
        ]);
    }
}
