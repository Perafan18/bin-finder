<?php

use App\Models\Bin;
use App\Models\Provider;
use App\Services\BinServiceInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;

uses(RefreshDatabase::class);

describe('BinController Edge Cases', function () {
    describe('caching', function () {
        it('caches bin data for 30 minutes', function () {
            $bin = Bin::factory()->create(['bin' => '123456']);

            Cache::shouldReceive('get')
                ->once()
                ->with('bin_info_123456')
                ->andReturn(null);

            Cache::shouldReceive('put')
                ->once()
                ->withArgs(function ($key, $value, $ttl) {
                    return $key === 'bin_info_123456' &&
                           $ttl->diffInMinutes(now()) === 30;
                })
                ->andReturn(true);

            $response = $this->getJson('/api/bin/123456');

            $response->assertOk();
        });

        it('generates correct cache key for bin', function () {
            $controller = new \App\Http\Controllers\BinController(
                app(BinServiceInterface::class)
            );

            $reflection = new ReflectionClass($controller);
            $method = $reflection->getMethod('getCacheKey');

            $cacheKey = $method->invoke($controller, '123456');

            expect($cacheKey)->toBe('bin_info_123456');
        });

        it('handles concurrent requests with caching', function () {
            $provider = Provider::factory()->create(['enabled' => true]);
            $binNumber = '123456';

            $this->mock(BinServiceInterface::class, function ($mock) use ($provider, $binNumber) {
                $mock->shouldReceive('getBinInfo')
                    ->once()
                    ->andReturn([
                        'bin' => $binNumber,
                        'type' => 'debit',
                        'brand' => 'Visa',
                        'country' => 'US',
                        'bank' => 'Test Bank',
                        'provider_id' => $provider->id,
                    ]);
            });

            $response1 = $this->getJson("/api/bin/{$binNumber}");
            $response2 = $this->getJson("/api/bin/{$binNumber}");

            $response1->assertOk();
            $response2->assertOk();

            expect(Bin::where('bin', $binNumber)->count())->toBe(1);
        });
    });

    describe('data retrieval', function () {
        it('returns database bin when service fails but database has data', function () {
            $provider = Provider::factory()->create();
            $bin = Bin::factory()->create([
                'bin' => '123456',
                'type' => 'credit',
                'provider_id' => $provider->id,
            ]);

            Cache::flush();

            $response = $this->getJson('/api/bin/123456');

            $response->assertOk()
                ->assertJson([
                    'bin' => '123456',
                    'type' => 'credit',
                ]);
        });

        it('creates bin with all required fields from service response', function () {
            $provider = Provider::factory()->create(['enabled' => true]);
            $binNumber = '654321';

            $this->mock(BinServiceInterface::class, function ($mock) use ($provider) {
                $mock->shouldReceive('getBinInfo')
                    ->andReturn([
                        'type' => 'prepaid',
                        'brand' => 'Mastercard',
                        'bank' => 'Test Bank Corp',
                        'country' => 'MX',
                        'provider_id' => $provider->id,
                    ]);
            });

            $response = $this->getJson("/api/bin/{$binNumber}");

            $response->assertOk();

            $bin = Bin::where('bin', $binNumber)->first();

            expect($bin)->not->toBeNull()
                ->and($bin->type)->toBe('prepaid')
                ->and($bin->brand)->toBe('Mastercard')
                ->and($bin->bank)->toBe('Test Bank Corp')
                ->and($bin->country)->toBe('MX')
                ->and($bin->provider_id)->toBe($provider->id);
        });
    });

    describe('error handling', function () {
        it('handles empty bin number gracefully', function () {
            $response = $this->getJson('/api/bin/');

            $response->assertNotFound();
        });

        it('handles very long bin numbers', function () {
            $longBin = str_repeat('1', 100);

            $response = $this->getJson("/api/bin/{$longBin}");

            $response->assertNotFound();
        });
    });
});
