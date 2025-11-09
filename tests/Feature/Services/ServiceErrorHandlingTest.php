<?php

use App\Services\Adapters\BinCheckAdapter;
use App\Services\BinCheckService;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;

it('handles HTTP client exceptions gracefully', function () {
    $adapter = new BinCheckAdapter;
    $service = new BinCheckService($adapter);

    $mockClient = Mockery::mock(Client::class);
    $mockClient->shouldReceive('post')
        ->andThrow(new ClientException(
            'Not Found',
            new Request('POST', 'test'),
            new Response(404)
        ));

    $reflection = new ReflectionClass($service);
    $property = $reflection->getProperty('client');
    $property->setValue($service, $mockClient);

    expect(fn () => $service->getBinInfo('123456'))
        ->toThrow(ClientException::class);
});

it('handles connection exceptions', function () {
    $adapter = new BinCheckAdapter;
    $service = new BinCheckService($adapter);

    $mockClient = Mockery::mock(Client::class);
    $mockClient->shouldReceive('post')
        ->andThrow(new ConnectException(
            'Connection timeout',
            new Request('POST', 'test')
        ));

    $reflection = new ReflectionClass($service);
    $property = $reflection->getProperty('client');
    $property->setValue($service, $mockClient);

    expect(fn () => $service->getBinInfo('123456'))
        ->toThrow(ConnectException::class);
});

it('handles invalid JSON response', function () {
    $adapter = new BinCheckAdapter;
    $service = new BinCheckService($adapter);

    $mockClient = Mockery::mock(Client::class);
    $mockClient->shouldReceive('post')
        ->andReturn(new Response(200, [], 'invalid json'));

    $reflection = new ReflectionClass($service);
    $property = $reflection->getProperty('client');
    $property->setValue($service, $mockClient);

    expect(fn () => $service->getBinInfo('123456'))
        ->toThrow(\JsonException::class);
});

it('handles empty response body', function () {
    $adapter = new BinCheckAdapter;
    $service = new BinCheckService($adapter);

    $mockClient = Mockery::mock(Client::class);
    $mockClient->shouldReceive('post')
        ->andReturn(new Response(200, [], ''));

    $reflection = new ReflectionClass($service);
    $property = $reflection->getProperty('client');
    $property->setValue($service, $mockClient);

    expect(fn () => $service->getBinInfo('123456'))
        ->toThrow(\JsonException::class);
});

it('handles 500 server error', function () {
    $adapter = new BinCheckAdapter;
    $service = new BinCheckService($adapter);

    $mockClient = Mockery::mock(Client::class);
    $mockClient->shouldReceive('post')
        ->andThrow(new RequestException(
            'Server Error',
            new Request('POST', 'test'),
            new Response(500)
        ));

    $reflection = new ReflectionClass($service);
    $property = $reflection->getProperty('client');
    $property->setValue($service, $mockClient);

    expect(fn () => $service->getBinInfo('123456'))
        ->toThrow(RequestException::class);
});

it('handles rate limiting', function () {
    $adapter = new BinCheckAdapter;
    $service = new BinCheckService($adapter);

    $mockClient = Mockery::mock(Client::class);
    $mockClient->shouldReceive('post')
        ->andThrow(new ClientException(
            'Too Many Requests',
            new Request('POST', 'test'),
            new Response(429)
        ));

    $reflection = new ReflectionClass($service);
    $property = $reflection->getProperty('client');
    $property->setValue($service, $mockClient);

    expect(fn () => $service->getBinInfo('123456'))
        ->toThrow(ClientException::class);
});
