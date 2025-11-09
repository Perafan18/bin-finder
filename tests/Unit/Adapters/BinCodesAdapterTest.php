<?php

use App\Services\Adapters\BinCodesAdapter;

it('extracts type from response', function () {
    $adapter = new BinCodesAdapter;
    $response = ['type' => 'CREDIT'];

    expect($adapter->getType($response))->toBe('CREDIT');
});

it('returns null when type is missing', function () {
    $adapter = new BinCodesAdapter;
    $response = [];

    expect($adapter->getType($response))->toBeNull();
});

it('extracts brand from response', function () {
    $adapter = new BinCodesAdapter;
    $response = ['card' => 'VISA'];

    expect($adapter->getBrand($response))->toBe('VISA');
});

it('returns null when brand is missing', function () {
    $adapter = new BinCodesAdapter;
    $response = [];

    expect($adapter->getBrand($response))->toBeNull();
});

it('extracts bank from response', function () {
    $adapter = new BinCodesAdapter;
    $response = ['bank' => 'Test Bank'];

    expect($adapter->getBank($response))->toBe('Test Bank');
});

it('returns null when bank is missing', function () {
    $adapter = new BinCodesAdapter;
    $response = [];

    expect($adapter->getBank($response))->toBeNull();
});

it('extracts country from response', function () {
    $adapter = new BinCodesAdapter;
    $response = ['countrycode' => 'US'];

    expect($adapter->getCountry($response))->toBe('US');
});

it('returns null when country is missing', function () {
    $adapter = new BinCodesAdapter;
    $response = [];

    expect($adapter->getCountry($response))->toBeNull();
});

it('handles empty response', function () {
    $adapter = new BinCodesAdapter;
    $response = [];

    expect($adapter->getType($response))->toBeNull()
        ->and($adapter->getBrand($response))->toBeNull()
        ->and($adapter->getBank($response))->toBeNull()
        ->and($adapter->getCountry($response))->toBeNull();
});
