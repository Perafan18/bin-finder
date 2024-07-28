<?php

use App\Models\Provider;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('lists providers', function () {
    $provider = Provider::factory()->create();

    $response = $this->get('/api/providers');

    $response->assertStatus(200)
        ->assertJson([
            ['name' => $provider->name, 'enabled' => $provider->enabled],
        ]);
});

it('returns not found for missing provider', function () {
    $response = $this->post('/api/providers/999/toggle');

    $response->assertStatus(404)
        ->assertJson(['message' => 'Provider not found']);
});

it('toggles provider status', function () {
    $provider = Provider::factory()->create(['enabled' => true]);

    $response = $this->post("/api/providers/{$provider->id}/toggle");

    $response->assertStatus(200)
        ->assertJson(['enabled' => false]);

    expect($provider->fresh()->enabled)->toBeFalse();
});
