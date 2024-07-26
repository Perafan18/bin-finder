<?php

use App\Services\Adapters\BinListAdapter;
use App\Services\BinListService;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;

it('returns data from BinListService', function ($response) {
    $client = Mockery::mock(Client::class);
    $client->shouldReceive('get')
        ->andReturn(new Response(200, [], json_encode($response)));

    $service = new BinListService(new BinListAdapter());
    $reflection = new ReflectionClass($service);
    $property = $reflection->getProperty('client');
    $property->setValue($service, $client);

    $data = $service->getBinInfo('123456');

    expect($data['type'])->toBeString()
        ->and($data['scheme'])->toBeString()
        ->and($data['bank'])->toBeArray()
        ->and($data['country'])->toBeArray();

    $response = $service->response($data);

    expect($response)->toBeArray()
        ->and($response['type'])->toBe($data['type'])
        ->and($response['brand'])->toBe($data['scheme'])
        ->and($response['bank'])->toBe($data['bank']['name'] ?? null)
        ->and($response['country'])->toBe($data['country']['alpha2'] );

})->with('bin list success responses');
