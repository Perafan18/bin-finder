<?php

namespace App\Services\Adapters;

class GreipAdapter implements BinAdapterInterface
{

    public function getType(array $response): ?string
    {
        return $response['data']['info']['scheme']['type'] ?? null;
    }

    public function getBrand(array $response): ?string
    {
        return $response['data']['info']['scheme']['name'] ?? null;
    }

    public function getBank(array $response): ?string
    {
        return $response['data']['info']['bank']['name'] ?? null;
    }

    public function getCountry(array $response): ?string
    {
        return $response['data']['info']['country']['alpha2'] ?? null;
    }
}
