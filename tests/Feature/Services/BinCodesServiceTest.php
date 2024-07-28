<?php

use App\Services\Adapters\BinCodesAdapter;
use App\Services\BinCodesService;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;

it('returns data from BinCodesService', function ($response) {
    $client = Mockery::mock(Client::class);
    $client->shouldReceive('get')
        ->andReturn(new Response(200, [], json_encode($response)));

    $service = new BinCodesService(new BinCodesAdapter);
    $reflection = new ReflectionClass($service);
    $property = $reflection->getProperty('client');
    $property->setValue($service, $client);

    $data = $service->getBinInfo('123456');

    expect($data)->toBeArray()
        ->and($data['type'])->toBeString()
        ->and($data['card'])->toBeString()
        ->and($data['bank'])->toBeString()
        ->and($data['countrycode'])->toBeString();

    $response = $service->response($data);

    expect($response)->toBeArray()
        ->and($response['type'])->toBe($data['type'])
        ->and($response['brand'])->toBe($data['card'])
        ->and($response['bank'])->toBe($data['bank'])
        ->and($response['country'])->toBe($data['countrycode']);

})->with('bin codes success responses');
