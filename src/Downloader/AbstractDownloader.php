<?php

namespace Buismaarten\Crawler\Downloader;

use Buismaarten\Crawler\Entities\Resource;

abstract class AbstractDownloader
{
    abstract public function download(string $url): ?Resource;
}
