<?php

namespace App\Services\Adapters;

class IinListAdapter implements BinAdapterInterface
{
    public function getType(array $response): ?string
    {
        return $response['_embedded']['cards'][0]['account']['funding'] ?? null;
    }

    public function getBrand(array $response): ?string
    {
        return $response['_embedded']['cards'][0]['scheme']['name'] ?? null;
    }

    public function getBank(array $response): ?string
    {
        return $response['_embedded']['cards'][0]['issuer']['name'] ?? null;
    }

    public function getCountry(array $response): ?string
    {
        return $response['_embedded']['cards'][0]['account']['country']['code'] ?? null;
    }
}
