<?php

namespace App\Services;

class GreipService extends BaseBinService
{
    public function getBinInfo(string $bin)
    {
        $response = $this->client->get(
            "https://greipapi.com/BINLookup?bin={$bin}",
            [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->api_key()
                ]
            ]
        );

        return json_decode($response->getBody()->getContents(), true);
    }

    private function api_key()
    {
        return config ('services.greip.key');
    }
}
