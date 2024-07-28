<?php

namespace App\Http\Controllers;

use App\Models\Provider;

class ProviderController extends Controller
{
    public function index()
    {
        $providers = Provider::all();

        return response()->json($providers);
    }

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
