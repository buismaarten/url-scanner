<?php

declare(strict_types=1);

namespace Buismaarten\UrlScanner\Downloaders;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\TransferException;
use GuzzleHttp\Psr7\Request;

// @todo
class GuzzleDownloader extends AbstractDownloader
{
    public function download(string $url): string
    {
        try {
            $client = new Client;
            $response = $client->send(new Request('GET', $url));
        } catch (TransferException) {
            return '';
        }

        return $response->getBody()->read($this->getLength());
    }
}
