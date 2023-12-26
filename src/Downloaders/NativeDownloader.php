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
                    'header' => [
                        'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.3',
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
