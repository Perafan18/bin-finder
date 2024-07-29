<?php

namespace App\Http\Controllers;

use App\Models\Provider;
use OpenApi\Attributes as OA;

#[OA\PathItem(path: '/api/providers')]
class ProviderController extends Controller
{
    #[OA\Get(
        path: '/api/providers',
        summary: 'List all BIN providers',
        responses: [
            new OA\Response(
                response: 200,
                description: 'Successful response',
                content: new OA\JsonContent(
                    type: 'array',
                    items: new OA\Items(
                        properties: [
                            new OA\Property(property: 'name', type: 'string'),
                            new OA\Property(property: 'enabled', type: 'boolean'),
                        ],
                        type: 'object'
                    )
                )
            ),
        ]
    )]
    public function index()
    {
        $providers = Provider::all();

        return response()->json($providers);
    }

    #[OA\Post(
        path: '/api/providers/{id}/toggle',
        summary: 'Enable or disable a BIN provider',
        parameters: [
            new OA\Parameter(
                name: 'id',
                description: 'The ID of the provider to toggle',
                in: 'path',
                required: true,
                schema: new OA\Schema(type: 'integer')
            ),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Successful response',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'name', type: 'string'),
                        new OA\Property(property: 'enabled', type: 'boolean'),
                    ],
                    type: 'object'
                )
            ),
            new OA\Response(
                response: 404,
                description: 'Provider not found',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'message', type: 'string'),
                    ],
                    type: 'object'
                )
            ),
        ]
    )]
    public function toggle($id)
    {
        $provider = Provider::find($id);

        if (! $provider) {
            return response()->json(['message' => 'Provider not found'], 404);
        }

        $provider->enabled = ! $provider->enabled;
        $provider->save();

        return response()->json($provider);
    }
}
