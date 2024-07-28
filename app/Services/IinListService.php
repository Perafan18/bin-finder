<?php

namespace App\Services;

class IinListService extends BaseBinService
{
    public function getBinInfo(string $bin)
    {
        $response = $this->client->get(
            "https://api.iinlist.com/cards?bin={$bin}",
            [
                'headers' => [
                    'X-API-Key' => $this->api_key(),
                ],
            ]
        );

        return json_decode($response->getBody()->getContents(), true);
    }

    private function api_key()
    {
        return config('services.iinlist.key');
    }
}
