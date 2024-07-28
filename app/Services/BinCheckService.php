<?php

namespace App\Services;

class BinCheckService extends BaseBinService
{
    public function getBinInfo(string $bin)
    {
        $response = $this->client->post(
            "https://bin-ip-checker.p.rapidapi.com/?bin={$bin}",
            [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'x-rapidapi-host' => 'bin-ip-checker.p.rapidapi.com',
                    'x-rapidapi-key' => $this->api_key(),
                ],
            ]
        );

        return json_decode($response->getBody()->getContents(), true);
    }

    private function api_key()
    {
        return config('services.bin_check.api_key');
    }
}
