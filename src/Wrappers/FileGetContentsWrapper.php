<?php

declare(strict_types=1);

namespace Buismaarten\UrlScanner\Wrappers;

class FileGetContentsWrapper
{
    /** @phpstan-ignore-next-line */
    private ?array $options = null;

    /** @phpstan-ignore-next-line */
    private ?array $params = null;

    /** @phpstan-ignore-next-line */
    public function __construct(array $options = null, array $params = null)
    {
        $this->setOptions($options);
        $this->setParams($params);
    }

    public function fileGetContents(string $filename, ?int $length = null): string|false
    {
        $context = stream_context_create($this->options, $this->params);
        $length = max(0, $length);

        return file_get_contents($filename, context: $context, length: $length);
    }

    /** @phpstan-ignore-next-line */
    public function setOptions(?array $options): void
    {
        $this->options = $options;
    }

    /** @phpstan-ignore-next-line */
    public function setParams(?array $params): void
    {
        $this->params = $params;
    }
}
