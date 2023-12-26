<?php

declare(strict_types=1);

namespace Buismaarten\UrlScanner\Downloaders;

use Buismaarten\UrlScanner\Utils;

final class NativeDownloader extends AbstractDownloader
{
    public function download(string $url): string
    {
        $body = false;

        // @todo
        if (Utils::validateUrl($url)) {
            $context = stream_context_create([
                'http' => [
                    'method' => 'GET',
                    'ignore_errors' => true,
                    'header' => [
                        "User-Agent: {$this->getUserAgent()}",
                    ],
                ],
            ]);

            $body = file_get_contents(
                filename: $url,
                context:  $context,
                length:   $this->getLength(),
            );
        }

        if ($body === false) {
            return '';
        }

        return $body;
    }
}
