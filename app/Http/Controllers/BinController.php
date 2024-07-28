<?php

namespace App\Http\Controllers;

use App\Models\Bin;
use App\Services\BinServiceInterface;
use Cache;

class BinController extends Controller
{
    protected BinServiceInterface $binService;

    public function __construct(BinServiceInterface $binService)
    {
        $this->binService = $binService;
    }

    /**
     * Display the specified resource.
     */
    public function show($bin)
    {
        $cacheKey = $this->getCacheKey($bin);

        if ($cachedBin = $this->getCachedBin($cacheKey)) {
            return response()->json($cachedBin);
        }

        if ($binData = $this->getBinData($bin)) {
            $this->cacheBinData($cacheKey, $binData);

            return response()->json($binData);
        }

        if ($data = $this->binService->getBinInfo($bin)) {
            $binData = $this->createBin($bin, $data);
            $this->cacheBinData($cacheKey, $binData);

            return response()->json($binData);
        }

        return response()->json(['message' => 'BIN not found'], 404);
    }

    protected function getCacheKey($bin)
    {
        return "bin_info_{$bin}";
    }

    protected function getCachedBin($cacheKey)
    {
        return Cache::get($cacheKey);
    }

    protected function getBinData($bin)
    {
        return Bin::where('bin', $bin)->first();
    }

    protected function cacheBinData($cacheKey, $binData)
    {
        Cache::put($cacheKey, $binData, now()->addMinutes(30));
    }

    protected function createBin($bin, $data)
    {
        return Bin::create([
            'bin' => $bin,
            'type' => $data['type'],
            'brand' => $data['brand'],
            'bank' => $data['bank'],
            'country' => $data['country'],
            'provider_id' => $data['provider_id'],
        ]);
    }
}
