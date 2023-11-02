<?php

abstract class AbstractDownloader
{
    abstract public function download(string $url): string;
}
