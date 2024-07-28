<?php

use App\Services\Adapters\GreipAdapter;
use App\Services\GreipService;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;

it('returns data from GreipService', function ($response) {
    $client = Mockery::mock(Client::class);
    $client->shouldReceive('get')
        ->andReturn(new Response(200, [], json_encode($response)));

    $service = new GreipService(new GreipAdapter());
    $reflection = new ReflectionClass($service);
    $property = $reflection->getProperty('client');
    $property->setValue($service, $client);

    $data = $service->getBinInfo('123456');

    expect($data)->toBeArray()
        ->and($data['data']['info']['scheme']['type'])->toBeString()
        ->and($data['data']['info']['scheme']['name'])->toBeString()
        ->and($data['data']['info']['bank']['name'])->toBeString()
        ->and($data['data']['info']['country']['alpha2'])->toBeString();

    $response = $service->response($data);

    expect($response)->toBeArray()
        ->and($response['type'])->toBe($data['data']['info']['scheme']['type'])
        ->and($response['brand'])->toBe($data['data']['info']['scheme']['name'])
        ->and($response['bank'])->toBe($data['data']['info']['bank']['name'])
        ->and($response['country'])->toBe($data['data']['info']['country']['alpha2']);
})->with('Greip success responses');
