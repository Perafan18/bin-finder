<?php

use App\Http\Resources\BinResource;
use App\Models\Bin;
use App\Models\Provider;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('transforms bin model to array', function () {
    $provider = Provider::factory()->create(['name' => 'TestProvider']);

    $bin = Bin::factory()->create([
        'bin' => '123456',
        'type' => 'credit',
        'brand' => 'VISA',
        'bank' => 'Test Bank',
        'country' => 'US',
        'provider_id' => $provider->id,
    ]);

    $resource = new BinResource($bin);
    $array = $resource->toArray(request());

    expect($array)->toBeArray()
        ->and($array['bin'])->toBe('123456')
        ->and($array['type'])->toBe('credit')
        ->and($array['brand'])->toBe('VISA')
        ->and($array['bank'])->toBe('Test Bank')
        ->and($array['country'])->toBe('US')
        ->and($array['provider'])->toBe($provider->id);
});

it('includes all required fields', function () {
    $bin = Bin::factory()->create();
    $resource = new BinResource($bin);
    $array = $resource->toArray(request());

    expect($array)->toHaveKeys([
        'bin',
        'type',
        'brand',
        'bank',
        'country',
        'provider',
    ]);
});

it('handles null values correctly', function () {
    $provider = Provider::factory()->create();

    $bin = new Bin([
        'bin' => '654321',
        'type' => null,
        'brand' => null,
        'bank' => null,
        'country' => null,
        'provider_id' => $provider->id,
    ]);

    $bin->save();

    $resource = new BinResource($bin);
    $array = $resource->toArray(request());

    expect($array['bin'])->toBe('654321')
        ->and($array['type'])->toBeNull()
        ->and($array['brand'])->toBeNull()
        ->and($array['bank'])->toBeNull()
        ->and($array['country'])->toBeNull()
        ->and($array['provider'])->toBe($provider->id);
});
