<?php

namespace App\Services\Api;

use GuzzleHttp\ClientInterface;

interface ApiInterface
{
    public function setBaseUri($baseUri);

    public function setClient(ClientInterface $client);
}
