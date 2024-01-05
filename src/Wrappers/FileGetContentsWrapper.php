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
        $this->options = $options;
        $this->params = $params;
    }

    /** @param resource $context */
    public function file_get_contents(string $filename, bool $use_include_path = false, mixed $context = null, int $offset = 0, ?int $length = null): string|false
    {
        if (! is_resource($context)) {
            $context = stream_context_create($this->options, $this->params);
        }

        if ($length < 0) {
            $length = null;
        }

        return file_get_contents($filename, $use_include_path, $context, $offset, $length);
    }
}
