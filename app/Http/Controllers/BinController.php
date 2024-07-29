<?php

namespace App\Http\Controllers;

use App\Models\Bin;
use App\Services\BinServiceInterface;
use Cache;
use OpenApi\Attributes as OA;

#[OA\PathItem(path: '/api/bin')]
class BinController extends Controller
{
    protected BinServiceInterface $binService;

    public function __construct(BinServiceInterface $binService)
    {
        $this->binService = $binService;
    }

    #[OA\Get(
        path: '/api/bin/{bin}',
        summary: 'Fetch BIN information',
        parameters: [
            new OA\Parameter(
                name: 'bin',
                description: 'The BIN number to fetch information for',
                in: 'path',
                required: true,
                schema: new OA\Schema(type: 'string')
            ),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Successful response',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'bin', type: 'string'),
                        new OA\Property(property: 'type', type: 'string'),
                        new OA\Property(property: 'brand', type: 'string'),
                        new OA\Property(property: 'bank', type: 'string'),
                        new OA\Property(property: 'country', type: 'string'),
                        new OA\Property(property: 'provider_id', type: 'integer'),
                    ],
                    type: 'object'
                )
            ),
            new OA\Response(
                response: 404,
                description: 'BIN not found',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'message', type: 'string'),
                    ],
                    type: 'object'
                )
            ),
        ]
    )]
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
