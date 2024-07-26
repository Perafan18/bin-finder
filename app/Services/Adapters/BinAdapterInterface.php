<?php

namespace App\Services\Adapters;

interface BinAdapterInterface
{
    public function getType(array $response): ?string;

    public function getBrand(array $response): ?string;

    public function getBank(array $response): ?string;

    public function getCountry(array $response): ?string;
}

