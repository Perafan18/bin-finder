<?php

namespace App\Services;

use GuzzleHttp\Client;

class BinCheckService implements BinServiceInterface
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    public function getBinInfo(string $bin)
    {
        $response = $this->client->get("https://bincheck.io/bin/{$bin}");
        return json_decode($response->getBody()->getContents(), true);
    }
}
