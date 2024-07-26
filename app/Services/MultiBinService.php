<?php

namespace App\Services;

use App\Models\Provider;

class MultiBinService implements BinServiceInterface
{
    protected array $services;

    public function __construct(array $services)
    {
        $this->services = $services;
    }

    public function getBinInfo(string $bin): ?array
    {
        $providers = Provider::where('enabled', true)->get();

        foreach ($providers as $provider) {
            $service = $this->services[$provider->name];
            try {
                $data = $service->getBinInfo($bin);
                if (!empty($data)) {
                    return array_merge(
                        $service->response($data),
                        ['provider_id' => $provider->id]
                    );
                }
            } catch (\Exception $e) {
                \Log::error("Error fetching BIN info from {$provider->name}: {$e->getMessage()}");
            }
        }

        return null;
    }
}
