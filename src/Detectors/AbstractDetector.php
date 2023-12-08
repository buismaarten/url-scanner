<?php

declare(strict_types=1);

namespace Buismaarten\UrlScanner\Detectors;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use League\Uri\Contracts\UriInterface;

abstract class AbstractDetector
{
    private Client $client;

    public function __construct(Client $client = null)
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
        if (! isset($this->client)) {
            $this->setClient(static::getDefaultClient());
        }

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

    /** @return iterable<string> */
    abstract public function detect(UriInterface $url): iterable;
}
