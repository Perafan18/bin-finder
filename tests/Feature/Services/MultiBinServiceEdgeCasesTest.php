<?php

use App\Models\Provider;
use App\Services\BinCheckService;
use App\Services\BinListService;
use App\Services\MultiBinService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Log;

uses(RefreshDatabase::class);

describe('MultiBinService Edge Cases', function () {
    describe('provider management', function () {
        it('handles all providers disabled', function () {
            Provider::factory()->create(['name' => 'bincheck', 'enabled' => false]);
            Provider::factory()->create(['name' => 'binlist', 'enabled' => false]);

            $mockBinCheck = Mockery::mock(BinCheckService::class);
            $mockBinList = Mockery::mock(BinListService::class);

            $service = new MultiBinService([
                'bincheck' => $mockBinCheck,
                'binlist' => $mockBinList,
            ]);

            $result = $service->getBinInfo('123456');

            expect($result)->toBeNull();
        });

        it('skips disabled providers', function () {
            $enabledProvider = Provider::factory()->create(['name' => 'bincheck', 'enabled' => true]);
            $disabledProvider = Provider::factory()->create(['name' => 'binlist', 'enabled' => false]);

            $mockEnabledService = Mockery::mock(BinCheckService::class);
            $mockEnabledService->shouldReceive('getBinInfo')
                ->once()
                ->andReturn(['BIN' => ['type' => 'CREDIT']]);
            $mockEnabledService->shouldReceive('response')
                ->once()
                ->andReturn([
                    'type' => 'CREDIT',
                    'brand' => 'VISA',
                    'bank' => 'Test Bank',
                    'country' => 'US',
                ]);

            $mockDisabledService = Mockery::mock(BinListService::class);
            $mockDisabledService->shouldNotReceive('getBinInfo');

            $service = new MultiBinService([
                'bincheck' => $mockEnabledService,
                'binlist' => $mockDisabledService,
            ]);

            $result = $service->getBinInfo('123456');

            expect($result)->not->toBeNull()
                ->and($result['provider_id'])->toBe($enabledProvider->id);
        });
    });

    describe('error handling', function () {
        it('logs errors when service throws exception', function () {
            Log::shouldReceive('error')
                ->once()
                ->with(Mockery::pattern('/Error fetching BIN info from bincheck:/'));

            $provider = Provider::factory()->create(['name' => 'bincheck', 'enabled' => true]);

            $mockService = Mockery::mock(BinCheckService::class);
            $mockService->shouldReceive('getBinInfo')
                ->andThrow(new \Exception('API Error'));

            $service = new MultiBinService([
                'bincheck' => $mockService,
            ]);

            $result = $service->getBinInfo('123456');

            expect($result)->toBeNull();
        });
    });

    describe('provider fallback', function () {
        it('returns data from first provider that succeeds', function () {
            $provider1 = Provider::factory()->create(['name' => 'bincheck', 'enabled' => true]);
            $provider2 = Provider::factory()->create(['name' => 'binlist', 'enabled' => true]);

            $mockService1 = Mockery::mock(BinCheckService::class);
            $mockService1->shouldReceive('getBinInfo')
                ->once()
                ->andReturn(['BIN' => ['type' => 'CREDIT']]);
            $mockService1->shouldReceive('response')
                ->once()
                ->andReturn([
                    'type' => 'CREDIT',
                    'brand' => 'VISA',
                    'bank' => 'Test Bank',
                    'country' => 'US',
                ]);

            $mockService2 = Mockery::mock(BinListService::class);
            $mockService2->shouldNotReceive('getBinInfo');

            $service = new MultiBinService([
                'bincheck' => $mockService1,
                'binlist' => $mockService2,
            ]);

            $result = $service->getBinInfo('123456');

            expect($result)->not->toBeNull()
                ->and($result['provider_id'])->toBe($provider1->id);
        });

        it('continues to next provider when current returns empty data', function () {
            $provider1 = Provider::factory()->create(['name' => 'bincheck', 'enabled' => true]);
            $provider2 = Provider::factory()->create(['name' => 'binlist', 'enabled' => true]);

            $mockService1 = Mockery::mock(BinCheckService::class);
            $mockService1->shouldReceive('getBinInfo')
                ->once()
                ->andReturn([]);

            $mockService2 = Mockery::mock(BinListService::class);
            $mockService2->shouldReceive('getBinInfo')
                ->once()
                ->andReturn(['type' => 'debit']);
            $mockService2->shouldReceive('response')
                ->once()
                ->andReturn([
                    'type' => 'debit',
                    'brand' => 'Mastercard',
                    'bank' => 'Test Bank 2',
                    'country' => 'MX',
                ]);

            $service = new MultiBinService([
                'bincheck' => $mockService1,
                'binlist' => $mockService2,
            ]);

            $result = $service->getBinInfo('123456');

            expect($result)->not->toBeNull()
                ->and($result['provider_id'])->toBe($provider2->id);
        });

        it('continues to next provider when current returns null', function () {
            $provider1 = Provider::factory()->create(['name' => 'bincheck', 'enabled' => true]);
            $provider2 = Provider::factory()->create(['name' => 'binlist', 'enabled' => true]);

            $mockService1 = Mockery::mock(BinCheckService::class);
            $mockService1->shouldReceive('getBinInfo')
                ->once()
                ->andReturn(null);

            $mockService2 = Mockery::mock(BinListService::class);
            $mockService2->shouldReceive('getBinInfo')
                ->once()
                ->andReturn(['type' => 'credit']);
            $mockService2->shouldReceive('response')
                ->once()
                ->andReturn([
                    'type' => 'credit',
                    'brand' => 'AMEX',
                    'bank' => 'American Express',
                    'country' => 'US',
                ]);

            $service = new MultiBinService([
                'bincheck' => $mockService1,
                'binlist' => $mockService2,
            ]);

            $result = $service->getBinInfo('123456');

            expect($result)->not->toBeNull()
                ->and($result['provider_id'])->toBe($provider2->id);
        });
    });
});
