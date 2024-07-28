<?php

use App\Models\Bin;
use App\Models\Provider;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('has fillable attributes', function () {
    $provider = Provider::factory()->create();

    $bin = new Bin([
        'bin' => '123456',
        'type' => 'credit',
        'brand' => 'Visa',
        'bank' => 'Test Bank',
        'country' => 'US',
        'provider_id' => $provider->id,
    ]);

    expect($bin->bin)->toBe('123456')
        ->and($bin->type)->toBe('credit')
        ->and($bin->brand)->toBe('Visa')
        ->and($bin->bank)->toBe('Test Bank')
        ->and($bin->country)->toBe('US')
        ->and($bin->provider->id)->toBe($provider->id);
});

it('has a factory', function () {
    $bin = Bin::factory()->create();

    expect($bin->bin)->toBeString()
        ->and($bin->type)->toBeString()
        ->and($bin->brand)->toBeString()
        ->and($bin->bank)->toBeString()
        ->and($bin->country)->toBeString()
        ->and($bin->provider_id)->toBeInt();
});
