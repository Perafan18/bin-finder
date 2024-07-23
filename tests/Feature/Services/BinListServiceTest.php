<?php

use App\Services\BinListService;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;

it('returns data from BinListService', function () {
    $client = Mockery::mock(Client::class);
    $client->shouldReceive('get')
        ->andReturn(new Response(200, [], json_encode(['brand' => 'Visa'])));

    $service = new BinListService();
    $reflection = new ReflectionClass($service);
    $property = $reflection->getProperty('client');
    $property->setValue($service, $client);

    $data = $service->getBinInfo('123456');

    expect($data['brand'])->toBe('Visa');
});
