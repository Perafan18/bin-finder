<?php

namespace App\Services;

use GuzzleHttp\Client;

class GreipService implements BinServiceInterface
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    public function getBinInfo(string $bin)
    {
        $response = $this->client->get("https://api.greip.io/bin/{$bin}");
        return json_decode($response->getBody()->getContents(), true);
    }
}
