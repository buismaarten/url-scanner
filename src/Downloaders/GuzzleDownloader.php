<?php

declare(strict_types=1);

namespace Buismaarten\UrlScanner\Downloaders;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\TransferException;
use GuzzleHttp\Psr7\Request;

class GuzzleDownloader extends AbstractDownloader
{
    private ClientInterface $client;

    public function __construct(ClientInterface $client = null)
    {
        $this->setClient($client);
    }

    public function download(string $url): string
    {
        try {
            $response = $this->client->send(new Request('GET', $url));
        } catch (TransferException) {
            return '';
        }

        return $response->getBody()->read($this->getLength());
    }

    public function setClient(?ClientInterface $client): void
    {
        if ($client === null) {
            $client = new Client;
        }

        $this->client = $client;
    }
}
