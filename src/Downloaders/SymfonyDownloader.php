<?php

declare(strict_types=1);

namespace Buismaarten\UrlScanner\Downloaders;

use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpClient\Response\StreamWrapper;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class SymfonyDownloader extends AbstractDownloader
{
    // @todo
    public function download(string $url): string
    {
        try {
            $client = HttpClient::create();
            $response = $client->request('GET', $url);

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
        } catch (TransportExceptionInterface) {
            return '';
        }
    }
}
