<?php

use App\Services\Adapters\BinCheckAdapter;
use App\Services\BinCheckService;

it('has a client instance', function () {
    $service = new BinCheckService(new BinCheckAdapter);

    $reflection = new ReflectionClass($service);
    $property = $reflection->getProperty('client');
    $client = $property->getValue($service);

    expect($client)->toBeInstanceOf(\GuzzleHttp\Client::class);
});

it('has an adapter instance', function () {
    $adapter = new BinCheckAdapter;
    $service = new BinCheckService($adapter);

    $reflection = new ReflectionClass($service);
    $property = $reflection->getProperty('adapter');
    $adapterInstance = $property->getValue($service);

    expect($adapterInstance)->toBeInstanceOf(BinCheckAdapter::class);
});

it('response method formats data correctly', function () {
    $adapter = new BinCheckAdapter;
    $service = new BinCheckService($adapter);

    $responseData = [
        'BIN' => [
            'type' => 'CREDIT',
            'brand' => 'VISA',
            'issuer' => [
                'name' => 'Test Bank',
            ],
            'country' => [
                'alpha2' => 'US',
            ],
        ],
    ];

    $result = $service->response($responseData);

    expect($result)->toBeArray()
        ->and($result)->toHaveKeys(['type', 'brand', 'bank', 'country'])
        ->and($result['type'])->toBe('CREDIT')
        ->and($result['brand'])->toBe('VISA')
        ->and($result['bank'])->toBe('Test Bank')
        ->and($result['country'])->toBe('US');
});

it('response method handles missing data gracefully', function () {
    $adapter = new BinCheckAdapter;
    $service = new BinCheckService($adapter);

    $responseData = ['BIN' => []];

    $result = $service->response($responseData);

    expect($result)->toBeArray()
        ->and($result['type'])->toBeNull()
        ->and($result['brand'])->toBeNull()
        ->and($result['bank'])->toBeNull()
        ->and($result['country'])->toBeNull();
});

it('uses adapter methods for data extraction', function () {
    $mockAdapter = Mockery::mock(BinCheckAdapter::class);
    $mockAdapter->shouldReceive('getType')->once()->andReturn('DEBIT');
    $mockAdapter->shouldReceive('getBrand')->once()->andReturn('Mastercard');
    $mockAdapter->shouldReceive('getBank')->once()->andReturn('Test Bank');
    $mockAdapter->shouldReceive('getCountry')->once()->andReturn('MX');

    $service = new BinCheckService($mockAdapter);

    $result = $service->response(['test' => 'data']);

    expect($result['type'])->toBe('DEBIT')
        ->and($result['brand'])->toBe('Mastercard')
        ->and($result['bank'])->toBe('Test Bank')
        ->and($result['country'])->toBe('MX');
});
