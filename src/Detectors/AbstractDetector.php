<?php

namespace Buismaarten\UrlScanner\Detectors;

use GuzzleHttp\Client;
use League\Uri\Contracts\UriInterface;

abstract class AbstractDetector
{
    private Client $client;

    public function __construct(?Client $client = null)
    {
        if ($client !== null) {
            $this->setClient($client);
        }
    }

    public function setClient(Client $client): void
    {
        $this->client = $client;
    }

    public function getClient(): Client
    {
        return $this->client;
    }

    /** @return UriInterface[] */
    abstract public function detect(UriInterface $url): array;
}
