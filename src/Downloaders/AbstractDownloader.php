<?php

namespace Buismaarten\Crawler\Downloaders;

use Buismaarten\Crawler\Resource;

abstract class AbstractDownloader
{
    abstract public function download(string $url): ?Resource;
}
