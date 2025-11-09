<?php

use App\Models\Bin;
use App\Models\Provider;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('belongs to a provider', function () {
    $provider = Provider::factory()->create();
    $bin = Bin::factory()->create(['provider_id' => $provider->id]);

    expect($bin->provider)->toBeInstanceOf(Provider::class)
        ->and($bin->provider->id)->toBe($provider->id);
});

it('can be queried by bin number', function () {
    $provider = Provider::factory()->create();
    $bin = Bin::factory()->create([
        'bin' => '123456',
        'provider_id' => $provider->id,
    ]);

    $found = Bin::where('bin', '123456')->first();

    expect($found)->not->toBeNull()
        ->and($found->id)->toBe($bin->id);
});

it('allows nullable fields', function () {
    $provider = Provider::factory()->create();
    $bin = Bin::create([
        'bin' => '123456',
        'type' => null,
        'brand' => null,
        'bank' => null,
        'country' => null,
        'provider_id' => $provider->id,
    ]);

    expect($bin->type)->toBeNull()
        ->and($bin->brand)->toBeNull()
        ->and($bin->bank)->toBeNull()
        ->and($bin->country)->toBeNull();
});

it('stores different card types correctly', function () {
    $provider = Provider::factory()->create();

    $creditBin = Bin::factory()->create(['type' => 'credit', 'provider_id' => $provider->id]);
    $debitBin = Bin::factory()->create(['type' => 'debit', 'provider_id' => $provider->id]);
    $prepaidBin = Bin::factory()->create(['type' => 'prepaid', 'provider_id' => $provider->id]);

    expect($creditBin->type)->toBe('credit')
        ->and($debitBin->type)->toBe('debit')
        ->and($prepaidBin->type)->toBe('prepaid');
});

it('stores different card brands correctly', function () {
    $provider = Provider::factory()->create();

    $visa = Bin::factory()->create(['brand' => 'VISA', 'provider_id' => $provider->id]);
    $mastercard = Bin::factory()->create(['brand' => 'Mastercard', 'provider_id' => $provider->id]);
    $amex = Bin::factory()->create(['brand' => 'American Express', 'provider_id' => $provider->id]);

    expect($visa->brand)->toBe('VISA')
        ->and($mastercard->brand)->toBe('Mastercard')
        ->and($amex->brand)->toBe('American Express');
});

it('can create multiple bins for the same provider', function () {
    $provider = Provider::factory()->create();

    Bin::factory()->count(5)->create(['provider_id' => $provider->id]);

    expect($provider->bins()->count())->toBe(5);
});

it('has timestamps', function () {
    $provider = Provider::factory()->create();
    $bin = Bin::factory()->create(['provider_id' => $provider->id]);

    expect($bin->created_at)->not->toBeNull()
        ->and($bin->updated_at)->not->toBeNull()
        ->and($bin->created_at)->toBeInstanceOf(\Illuminate\Support\Carbon::class)
        ->and($bin->updated_at)->toBeInstanceOf(\Illuminate\Support\Carbon::class);
});
