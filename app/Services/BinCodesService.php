<?php

namespace App\Services;

class BinCodesService extends BaseBinService
{
    public function getBinInfo(string $bin)
    {
        $response = $this->client->get(
            "https://api.bincodes.com/bin/?format=json&api_key={$this->api_key()}&bin={$bin}"
        );

        return json_decode($response->getBody()->getContents(), true);
    }

    private function api_key()
    {
        return config('services.bin_codes.api_key');
    }
}
