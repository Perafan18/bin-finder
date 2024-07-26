<?php

namespace App\Services;

class BinListService extends BaseBinService
{
    public function getBinInfo(string $bin)
    {
        $response = $this->client->get("https://lookup.binlist.net/{$bin}");
        return json_decode($response->getBody()->getContents(), true);
    }
}
