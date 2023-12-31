<?php

declare(strict_types=1);

namespace Buismaarten\UrlScanner\Downloaders;

use Buismaarten\UrlScanner\Utils;

class FileGetContentsDownloader extends AbstractDownloader
{
    /** @phpstan-ignore-next-line */
    private array $options;

    /** @phpstan-ignore-next-line */
    public function __construct(array $options = [])
    {
        $this->setOptions($options);
    }

    public function download(string $url): string
    {
        if (! Utils::validateUrl($url)) {
            return '';
        }

        $body = file_get_contents(filename: $url,
                                  use_include_path: false,
                                  context: stream_context_create($this->options),
                                  length: $this->getLength());

        if ($body === false) {
            return '';
        }

        return $body;
    }

    /** @phpstan-ignore-next-line */
    private function setOptions(array $options): void
    {
        $options['http']['ignore_errors'] ??= true;
        $options['http']['method'] ??= 'GET';

        $this->options = $options;
    }
}
