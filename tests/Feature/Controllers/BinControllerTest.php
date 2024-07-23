<?php

use App\Models\Bin;
use App\Models\Provider;
use App\Services\BinServiceInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;

uses(RefreshDatabase::class);


it('fetches bin data from database if not cached and caches it', function () {
    $bin = Bin::factory()->create(['bin' => '123456', 'type' => 'debit']);

    $response = $this->getJson("/api/bin/{$bin->bin}");

    $response->assertOk()
        ->assertJson(['bin' => '123456', 'type' => 'debit']);

    $this->assertNotNull(Cache::get("bin_info_{$bin->bin}"));
});

it('returns cached bin data if available', function () {
    $bin = Bin::factory()->create(['bin' => '123456', 'type' => 'credit']);
    Cache::put("bin_info_{$bin->bin}", ['bin' => $bin->bin, 'type' => 'credit'], now()->addMinutes(30));

    $response = $this->getJson("/api/bin/{$bin->bin}");

    $response->assertOk()
        ->assertJson(['bin' => '123456', 'type' => 'credit']);
});

it('returns bin from service, store in database and cached', function () {
    $provider = Provider::factory()->create(['name' => 'binlist', 'enabled' => true]);
    $bin_number = '123456';

    $this->mock(BinServiceInterface::class, function ($mock) use ($provider, $bin_number) {
        $mock->shouldReceive('getBinInfo')
            ->andReturn([
                'bin' => $bin_number,
                'type' => 'debit',
                'brand' => 'Visa',
                'country' => 'US',
                'bank' => 'Bank of America',
                'provider_id' => $provider->id,
            ]);
    });

    $response = $this->getJson("/api/bin/{$bin_number}");

    $response->assertOk()
        ->assertJson(['bin' => $bin_number, 'type' => 'debit']);

    $this->assertNotNull(Cache::get("bin_info_{$bin_number}"));
});

it('returns not found if bin data is unavailable', function () {
    $response = $this->getJson("/api/bin/999999");

    $response->assertNotFound()
        ->assertJson(['message' => 'BIN not found']);
});
