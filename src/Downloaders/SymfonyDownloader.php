<?php

declare(strict_types=1);

namespace Buismaarten\UrlScanner\Downloaders;

use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpClient\Response\StreamWrapper;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class SymfonyDownloader extends AbstractDownloader
{
    private HttpClientInterface $client;

    public function __construct(HttpClientInterface $client = null)
    {
        $this->setClient($client);
    }

    public function download(string $url): string
    {
        try {
            $response = $this->client->request('GET', $url);
        } catch (TransportExceptionInterface) {
            return '';
        }

        $stream = StreamWrapper::createResource($response);
        if (! is_resource($stream)) {
            return '';
        }

        $content = stream_get_contents($stream, $this->getLength());
        if ($content === false) {
            $content = '';
        }

        if (is_resource($stream)) {
            fclose($stream);
        }

        return $content;
    }

    public function setClient(?HttpClientInterface $client): void
    {
        if ($client === null) {
            $client = HttpClient::create();
        }

        $this->client = $client;
    }
}
