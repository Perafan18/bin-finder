<?php

namespace App\Services\Adapters;

class BinCheckAdapter implements BinAdapterInterface
{

    public function getType(array $response): ?string
    {
        return $response['BIN']['type'] ?? null;
    }

    public function getBrand(array $response): ?string
    {
        return $response['BIN']['brand'] ?? null;
    }

    public function getBank(array $response): ?string
    {
        return $response['BIN']['issuer']['name'] ?? null;
    }

    public function getCountry(array $response): ?string
    {
        return $response['BIN']['country']['alpha2'] ?? null;
    }
}
