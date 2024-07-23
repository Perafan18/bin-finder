<?php

use App\Models\Provider;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('has fillable attributes', function () {
    $provider = new Provider([
        'name' => 'binlist',
        'enabled' => true,
    ]);

    expect($provider->name)->toBe('binlist')
        ->and($provider->enabled)->toBeTrue();
});

it('has a factory', function () {
    $provider = Provider::factory()->create();

    expect($provider->name)->toBeString()
        ->and($provider->enabled)->toBeBool();
});

it('has bins relationship', function () {
    $provider = Provider::factory()->hasBins(3)->create();

    expect($provider->bins)->toHaveCount(3);
});

