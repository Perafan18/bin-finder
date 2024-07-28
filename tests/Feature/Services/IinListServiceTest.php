<?php

use App\Services\Adapters\IinListAdapter;
use App\Services\IinListService;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;

it('returns data from IinListService', function ($response) {
    $client = Mockery::mock(Client::class);
    $client->shouldReceive('get')
        ->andReturn(new Response(200, [], json_encode($response)));

    $service = new IinListService(new IinListAdapter());
    $reflection = new ReflectionClass($service);
    $property = $reflection->getProperty('client');
    $property->setValue($service, $client);

    $data = $service->getBinInfo('123456');

    expect($data)->toBeArray()
        ->and($data['_embedded']['cards'][0]['account']['funding'])->toBeString()
        ->and($data['_embedded']['cards'][0]['scheme']['name'])->toBeString()
        ->and($data['_embedded']['cards'][0]['issuer']['name'])->toBeString()
        ->and($data['_embedded']['cards'][0]['account']['country']['code'])->toBeString();

    $response = $service->response($data);

    expect($response)->toBeArray()
        ->and($response['type'])->toBe($data['_embedded']['cards'][0]['account']['funding'])
        ->and($response['brand'])->toBe($data['_embedded']['cards'][0]['scheme']['name'])
        ->and($response['bank'])->toBe($data['_embedded']['cards'][0]['issuer']['name'])
        ->and($response['country'])->toBe($data['_embedded']['cards'][0]['account']['country']['code']);
})->with('Iin list success responses');
