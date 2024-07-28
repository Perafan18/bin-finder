<?php

use App\Services\Adapters\BinCheckAdapter;
use App\Services\BinCheckService;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;

it('returns data from BinCheckService', function ($response) {
    $client = Mockery::mock(Client::class);
    $client->shouldReceive('post')
        ->andReturn(new Response(200, [], json_encode($response)));

    $service = new BinCheckService(new BinCheckAdapter);
    $reflection = new ReflectionClass($service);
    $property = $reflection->getProperty('client');
    $property->setValue($service, $client);

    $data = $service->getBinInfo('123456');

    expect($data)->toBeArray()
        ->and($data['BIN'])->toBeArray()
        ->and($data['BIN']['type'])->toBeString()
        ->and($data['BIN']['brand'])->toBeString()
        ->and($data['BIN']['issuer'])->toBeArray()
        ->and($data['BIN']['country'])->toBeArray();

    $response = $service->response($data);

    expect($response)->toBeArray()
        ->and($response['type'])->toBe($data['BIN']['type'])
        ->and($response['brand'])->toBe($data['BIN']['brand'])
        ->and($response['bank'])->toBe($data['BIN']['issuer']['name'] ?? null)
        ->and($response['country'])->toBe($data['BIN']['country']['alpha2']);
})->with('bin check success responses');
