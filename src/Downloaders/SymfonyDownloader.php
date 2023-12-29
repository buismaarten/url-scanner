<?php

declare(strict_types=1);

namespace Buismaarten\UrlScanner\Downloaders;

use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class SymfonyDownloader extends AbstractDownloader
{
    public function download(string $url): string
    {
        // @todo
        try {
            $client = HttpClient::create();
            $response = $client->request('GET', $url);

            return substr($response->getContent(), 0, $this->getLength());
        } catch (TransportExceptionInterface) {
            return '';
        }
    }
}
