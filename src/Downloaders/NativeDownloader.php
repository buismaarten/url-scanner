<?php

declare(strict_types=1);

namespace Buismaarten\UrlScanner\Downloaders;

use Buismaarten\UrlScanner\Utils;

final class NativeDownloader extends AbstractDownloader
{
    private array $options;

    public function download(string $url): string
    {
        $body = false;

        // @todo
        if (Utils::validateUrl($url)) {
            $body = file_get_contents($url,
                context: stream_context_create($this->getOptions()),
                length: $this->getLength(),
            );
        }

        if ($body === false) {
            return '';
        }

        return $body;
    }

    public function setOptions(array $options): void
    {
        $this->options = $options;
    }

    private function getOptions(): array
    {
        $options = ($this->options ??= self::getDefaultOptions());

        if ($this->getUserAgent() !== '') {
            $options['http']['header'][] = "User-Agent: {$this->getUserAgent()}";
        }

        return $options;
    }

    private static function getDefaultOptions(): array
    {
        return [
            'http' => [
                'method' => 'GET',
                'ignore_errors' => true,
                'header' => [
                    'Accept: text/html',
                    'Cache-Control: no-cache',
                ],
            ],
        ];
    }
}
