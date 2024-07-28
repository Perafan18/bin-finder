<?php

use App\Models\Provider;
use App\Services\BinCodesService as BinCodesService;
use App\Services\BinListService as BinListService;
use App\Services\MultiBinService;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    Provider::factory()->create([
        'name' => 'binlist',
        'enabled' => true,
    ]);

    Provider::factory()->create([
        'name' => 'bincodes',
        'enabled' => true,
    ]);

    $this->services = [
        'binlist' => Mockery::mock(BinListService::class),
        'bincodes' => Mockery::mock(BinCodesService::class),
    ];

    $this->multiBinService = new MultiBinService($this->services);
});

it('returns bin info from the first available provider', function () {
    $this->services['binlist']->shouldReceive('getBinInfo')
        ->with('123456')
        ->andReturn(['type' => 'credit', 'scheme' => 'visa', 'bank' => 'Test Bank', 'country' => 'US']);

    $this->services['binlist']->shouldReceive('response')
        ->andReturn(['type' => 'credit', 'brand' => 'visa', 'bank' => 'Test Bank', 'country' => 'US']);

    $binInfo = $this->multiBinService->getBinInfo('123456');

    expect($binInfo)->toBeArray()
        ->and($binInfo)->toHaveKeys(['type', 'brand', 'bank', 'country', 'provider_id'])
        ->and($binInfo['type'])->toBe('credit')
        ->and($binInfo['brand'])->toBe('visa')
        ->and($binInfo['bank'])->toBe('Test Bank')
        ->and($binInfo['country'])->toBe('US')
        ->and($binInfo['provider_id'])->toBe(Provider::where('name', 'binlist')->first()->id);
});

it('returns bin info from the second provider if the first fails', function () {
    $this->services['binlist']->shouldReceive('getBinInfo')
        ->with('123456')
        ->andThrow(new Exception('BinCheckService error'));

    $this->services['bincodes']->shouldReceive('getBinInfo')
        ->with('123456')
        ->andReturn(['type' => 'debit', 'scheme' => 'mastercard', 'bank' => 'Another Bank', 'country' => 'CA']);

    $this->services['bincodes']->shouldReceive('response')
        ->andReturn(['type' => 'debit', 'brand' => 'mastercard', 'bank' => 'Another Bank', 'country' => 'CA']);

    $binInfo = $this->multiBinService->getBinInfo('123456');

    expect($binInfo)->toBeArray()
        ->and($binInfo)->toHaveKeys(['type', 'brand', 'bank', 'country', 'provider_id'])
        ->and($binInfo['type'])->toBe('debit')
        ->and($binInfo['brand'])->toBe('mastercard')
        ->and($binInfo['bank'])->toBe('Another Bank')
        ->and($binInfo['country'])->toBe('CA')
        ->and($binInfo['provider_id'])->toBe(Provider::where('name', 'bincodes')->first()->id);
});

it('returns null if no provider returns data', function () {
    $this->services['binlist']->shouldReceive('getBinInfo')
        ->with('123456')
        ->andThrow(new Exception('BinCheckService error'));

    $this->services['bincodes']->shouldReceive('getBinInfo')
        ->with('123456')
        ->andThrow(new Exception('BinCheckService error'));

    $binInfo = $this->multiBinService->getBinInfo('123456');

    expect($binInfo)->toBeNull();
});
