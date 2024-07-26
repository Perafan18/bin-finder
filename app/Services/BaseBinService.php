<?php

namespace App\Services;

use App\Services\Adapters\BinAdapterInterface;
use GuzzleHttp\Client;

abstract class BaseBinService implements BinServiceInterface
{
    protected Client $client;
    protected BinAdapterInterface $adapter;

    public function __construct(BinAdapterInterface $adapter)
    {
        $this->client = new Client();
        $this->adapter = $adapter;
    }

    abstract public function getBinInfo(string $bin);

    public function response(array $response): array
    {
        return [
            'type' => $this->adapter->getType($response),
            'brand' => $this->adapter->getBrand($response),
            'bank' => $this->adapter->getBank($response),
            'country' => $this->adapter->getCountry($response),
        ];
    }
}
