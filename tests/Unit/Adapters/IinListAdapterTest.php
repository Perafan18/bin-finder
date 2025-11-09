<?php

use App\Services\Adapters\IinListAdapter;

it('extracts type from response', function () {
    $adapter = new IinListAdapter;
    $response = [
        '_embedded' => [
            'cards' => [
                [
                    'account' => [
                        'funding' => 'credit',
                    ],
                ],
            ],
        ],
    ];

    expect($adapter->getType($response))->toBe('credit');
});

it('returns null when type is missing', function () {
    $adapter = new IinListAdapter;
    $response = [];

    expect($adapter->getType($response))->toBeNull();
});

it('extracts brand from response', function () {
    $adapter = new IinListAdapter;
    $response = [
        '_embedded' => [
            'cards' => [
                [
                    'scheme' => [
                        'name' => 'VISA',
                    ],
                ],
            ],
        ],
    ];

    expect($adapter->getBrand($response))->toBe('VISA');
});

it('returns null when brand is missing', function () {
    $adapter = new IinListAdapter;
    $response = [];

    expect($adapter->getBrand($response))->toBeNull();
});

it('extracts bank from response', function () {
    $adapter = new IinListAdapter;
    $response = [
        '_embedded' => [
            'cards' => [
                [
                    'issuer' => [
                        'name' => 'Test Bank',
                    ],
                ],
            ],
        ],
    ];

    expect($adapter->getBank($response))->toBe('Test Bank');
});

it('returns null when bank is missing', function () {
    $adapter = new IinListAdapter;
    $response = [];

    expect($adapter->getBank($response))->toBeNull();
});

it('extracts country from response', function () {
    $adapter = new IinListAdapter;
    $response = [
        '_embedded' => [
            'cards' => [
                [
                    'account' => [
                        'country' => [
                            'code' => 'US',
                        ],
                    ],
                ],
            ],
        ],
    ];

    expect($adapter->getCountry($response))->toBe('US');
});

it('returns null when country is missing', function () {
    $adapter = new IinListAdapter;
    $response = [];

    expect($adapter->getCountry($response))->toBeNull();
});

it('handles empty response', function () {
    $adapter = new IinListAdapter;
    $response = [];

    expect($adapter->getType($response))->toBeNull()
        ->and($adapter->getBrand($response))->toBeNull()
        ->and($adapter->getBank($response))->toBeNull()
        ->and($adapter->getCountry($response))->toBeNull();
});
