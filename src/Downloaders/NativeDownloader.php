<?php

declare(strict_types=1);

namespace Buismaarten\UrlScanner\Downloaders;

use Buismaarten\UrlScanner\Utils;

final class NativeDownloader extends AbstractDownloader
{
    /** @phpstan-ignore-next-line */
    private array $options;

    public function download(string $url): string
    {
        $body = false;

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

    /** @phpstan-ignore-next-line */
    public function setOptions(array $options): void
    {
        $this->options = $options;
    }

    /** @phpstan-ignore-next-line */
    private function getOptions(): array
    {
        $options = ($this->options ??= self::getDefaultOptions());

        if ($this->getUserAgent() !== '') {
            $options['http']['header'][] = "User-Agent: {$this->getUserAgent()}";
        }

        return $options;
    }

    /** @phpstan-ignore-next-line */
    private static function getDefaultOptions(): array
    {
        return [
            'http' => [
                'method' => 'GET',
                'ignore_errors' => true,
            ],
        ];
    }
}
