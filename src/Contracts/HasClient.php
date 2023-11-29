<?php

namespace Buismaarten\UrlScanner\Contracts;

use GuzzleHttp\Client;

interface HasClient
{
    public function setClient(Client $client): void;
    public function getClient(): Client;
}
