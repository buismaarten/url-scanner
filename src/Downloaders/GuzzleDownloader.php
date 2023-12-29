<?php

declare(strict_types=1);

namespace Buismaarten\UrlScanner\Downloaders;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\TransferException;
use GuzzleHttp\Psr7\Request;

class GuzzleDownloader extends AbstractDownloader
{
    /** @phpstan-ignore-next-line */
    private array $options;

    public function download(string $url): string
    {
        try {
            $client = new Client;
            $response = $client->send(new Request('GET', $url), $this->getOptions());
        } catch (TransferException) {
            return '';
        }

        return $response->getBody()->read($this->getLength());
    }

    /** @phpstan-ignore-next-line */
    public function setOptions(array $options): void
    {
        $this->options = $options;
    }

    /** @phpstan-ignore-next-line */
    private function getOptions(): array
    {
        return ($this->options ??= $this->getDefaultOptions());
    }

    /** @phpstan-ignore-next-line */
    private function getDefaultOptions(): array
    {
        return [
            'headers' => $this->getHeaders(),
        ];
    }
}
