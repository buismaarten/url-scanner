<?php

declare(strict_types=1);

namespace Buismaarten\UrlScanner\Downloaders;

use Buismaarten\UrlScanner\Utils;

class FileGetContentsDownloader extends AbstractDownloader
{
    /** @phpstan-ignore-next-line */
    private array $options;

    public function download(string $url): string
    {
        $body = false;

        if (Utils::validateUrl($url)) {
            $body = file_get_contents(filename: $url,
                                      use_include_path: false,
                                      context: stream_context_create($this->getOptions()),
                                      length: $this->getLength());
        }

        if ($body === false) {
            return '';
        }

        return $body;
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
            'http' => [
                'method' => 'GET',
                'ignore_errors' => true,
                'header' => $this->getHeaders(),
            ],
        ];
    }

    /** @return string[] */
    protected function getHeaders(): array
    {
        $headers = [];

        foreach (parent::getHeaders() as $key => $value) {
            $headers[] = sprintf('%s: %s', $key, $value);
        }

        return $headers;
    }
}
