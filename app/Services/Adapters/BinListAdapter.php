<?php

namespace App\Services\Adapters;

class BinListAdapter implements BinAdapterInterface
{
    public function getType(array $response): ?string
    {
        return $response['type'] ?? null;
    }

    public function getBrand(array $response): ?string
    {
        return $response['scheme'] ?? null;
    }

    public function getBank(array $response): ?string
    {
        return $response['bank']['name'] ?? null;
    }

    public function getCountry(array $response): ?string
    {
        return $response['country']['alpha2'] ?? null;
    }
}
