<?php

namespace App\Services\Adapters;

class BinCodesAdapter implements BinAdapterInterface
{
    public function getType(array $response): ?string
    {
        return $response['type'] ?? null;
    }

    public function getBrand(array $response): ?string
    {
        return $response['card'] ?? null;
    }

    public function getBank(array $response): ?string
    {
        return $response['bank'] ?? null;
    }

    public function getCountry(array $response): ?string
    {
        return $response['countrycode'] ?? null;
    }
}
