<?php

use App\Models\Provider;
use App\Services\MultiBinService;
use App\Services\BinServiceInterface;

it('returns data from the first enabled provider', function () {
    Provider::factory()->create(['name' => 'binlist', 'enabled' => true]);

    $serviceMock = Mockery::mock(BinServiceInterface::class);
    $serviceMock->shouldReceive('getBinInfo')
        ->andReturn(['brand' => 'Visa']);

    $multiBinService = new MultiBinService(['binlist' => $serviceMock]);
    $data = $multiBinService->getBinInfo('123456');

    expect($data['brand'])->toBe('Visa')
        ->and($data['provider'])->toBe('binlist');
});
