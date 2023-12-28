<?php

declare(strict_types=1);

namespace Buismaarten\UrlScanner\Downloaders;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\TransferException;
use GuzzleHttp\Psr7\Request;

class GuzzleDownloader extends AbstractDownloader
{
    /** @phpstan-ignore-next-line */
    private array $config;

    public function download(string $url): string
    {
        try {
            $client = new Client($this->getConfig());
            $response = $client->send(new Request('GET', $url));
        } catch (TransferException) {
            return '';
        }

        return $response->getBody()->read($this->getLength());
    }

    /** @phpstan-ignore-next-line */
    public function setConfig(array $config): void
    {
        $this->config = $config;
    }

    /** @phpstan-ignore-next-line */
    private function getConfig(): array
    {
        return ($this->config ??= $this->getDefaultConfig());
    }

    /** @phpstan-ignore-next-line */
    private function getDefaultConfig(): array
    {
        // @todo
        return [];
    }
}