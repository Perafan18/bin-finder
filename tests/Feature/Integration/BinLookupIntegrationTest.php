<?php

use App\Models\Bin;
use App\Models\Provider;
use App\Services\BinServiceInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;

uses(RefreshDatabase::class);

it('completes full bin lookup flow from request to cache', function () {
    $provider = Provider::factory()->create(['name' => 'bincheck', 'enabled' => true]);

    $this->mock(BinServiceInterface::class, function ($mock) use ($provider) {
        $mock->shouldReceive('getBinInfo')
            ->once()
            ->with('452421')
            ->andReturn([
                'type' => 'CREDIT',
                'brand' => 'VISA',
                'bank' => 'Test Bank',
                'country' => 'MX',
                'provider_id' => $provider->id,
            ]);
    });

    $response = $this->getJson('/api/bin/452421');

    $response->assertOk()
        ->assertJson([
            'bin' => '452421',
            'type' => 'CREDIT',
            'brand' => 'VISA',
            'bank' => 'Test Bank',
            'country' => 'MX',
        ]);

    $binInDb = Bin::where('bin', '452421')->first();
    expect($binInDb)->not->toBeNull();

    $cached = Cache::get('bin_info_452421');
    expect($cached)->not->toBeNull();
});

it('uses cached data on subsequent requests', function () {
    $provider = Provider::factory()->create(['enabled' => true]);
    $bin = Bin::factory()->create([
        'bin' => '123456',
        'type' => 'credit',
        'brand' => 'VISA',
        'bank' => 'Test Bank',
        'country' => 'US',
        'provider_id' => $provider->id,
    ]);

    Cache::put('bin_info_123456', $bin, now()->addMinutes(30));

    $this->mock(BinServiceInterface::class, function ($mock) {
        $mock->shouldNotReceive('getBinInfo');
    });

    $response = $this->getJson('/api/bin/123456');

    $response->assertOk()
        ->assertJson([
            'bin' => '123456',
            'type' => 'credit',
        ]);
});

it('uses database data when cache is empty but database has data', function () {
    $provider = Provider::factory()->create(['enabled' => true]);
    $bin = Bin::factory()->create([
        'bin' => '654321',
        'type' => 'debit',
        'brand' => 'Mastercard',
        'bank' => 'Test Bank',
        'country' => 'MX',
        'provider_id' => $provider->id,
    ]);

    Cache::forget('bin_info_654321');

    $this->mock(BinServiceInterface::class, function ($mock) {
        $mock->shouldNotReceive('getBinInfo');
    });

    $response = $this->getJson('/api/bin/654321');

    $response->assertOk()
        ->assertJson([
            'bin' => '654321',
            'type' => 'debit',
        ]);

    $cached = Cache::get('bin_info_654321');
    expect($cached)->not->toBeNull();
});

it('provider can be toggled and affects bin lookup', function () {
    $provider = Provider::factory()->create(['name' => 'bincheck', 'enabled' => true]);

    $response = $this->postJson("/api/providers/{$provider->id}/toggle");

    $response->assertOk()
        ->assertJson(['enabled' => false]);

    expect($provider->fresh()->enabled)->toBeFalse();
});

it('handles multiple concurrent bin lookups', function () {
    $provider = Provider::factory()->create(['name' => 'bincheck', 'enabled' => true]);

    $this->mock(BinServiceInterface::class, function ($mock) use ($provider) {
        $mock->shouldReceive('getBinInfo')
            ->times(3)
            ->andReturn([
                'type' => 'CREDIT',
                'brand' => 'VISA',
                'bank' => 'Test Bank',
                'country' => 'US',
                'provider_id' => $provider->id,
            ]);
    });

    $bin1 = '111111';
    $bin2 = '222222';
    $bin3 = '333333';

    $response1 = $this->getJson("/api/bin/{$bin1}");
    $response2 = $this->getJson("/api/bin/{$bin2}");
    $response3 = $this->getJson("/api/bin/{$bin3}");

    $response1->assertOk();
    $response2->assertOk();
    $response3->assertOk();

    expect(Bin::count())->toBe(3);
});
