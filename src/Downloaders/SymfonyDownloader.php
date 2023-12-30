<?php

declare(strict_types=1);

namespace Buismaarten\UrlScanner\Downloaders;

use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpClient\Response\StreamWrapper;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class SymfonyDownloader extends AbstractDownloader
{
    /** @phpstan-ignore-next-line */
    private array $options;

    public function download(string $url): string
    {
        try {
            $client = HttpClient::create();
            $response = $client->request('GET', $url, $this->getOptions());
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
