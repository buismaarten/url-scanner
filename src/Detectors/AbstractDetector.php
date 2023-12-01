<?php

namespace Buismaarten\UrlScanner\Detectors;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use League\Uri\Contracts\UriInterface;

abstract class AbstractDetector
{
    private Client $client;

    public function __construct(?Client $client = null)
    {
        $this->setClient($client);
    }

    public function setClient(?Client $client): void
    {
        if ($client === null) {
            $client = static::getDefaultClient();
        }

        $this->client = $client;
    }

    public function getClient(): Client
    {
        return $this->client;
    }

    protected static function getDefaultClient(): Client
    {
        return new Client([
            RequestOptions::ALLOW_REDIRECTS => true,
            RequestOptions::CONNECT_TIMEOUT => 30,
            RequestOptions::HTTP_ERRORS => false,
            RequestOptions::TIMEOUT => 30,
        ]);
    }

    /** @return UriInterface[] */
    abstract public function detect(UriInterface $url): array;
}
