<?php

use App\Models\Provider;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

describe('ProviderController Edge Cases', function () {
    describe('listing providers', function () {
        it('returns empty array when no providers exist', function () {
            $response = $this->getJson('/api/providers');

            $response->assertOk()
                ->assertJson([]);
        });

        it('lists multiple providers', function () {
            Provider::factory()->count(3)->create();

            $response = $this->getJson('/api/providers');

            $response->assertOk()
                ->assertJsonCount(3);
        });

        it('lists providers with correct structure', function () {
            $provider = Provider::factory()->create([
                'name' => 'TestProvider',
                'enabled' => true,
            ]);

            $response = $this->getJson('/api/providers');

            $response->assertOk()
                ->assertJsonStructure([
                    '*' => ['id', 'name', 'enabled', 'created_at', 'updated_at'],
                ]);
        });
    });

    describe('toggling provider status', function () {
        it('toggles provider from disabled to enabled', function () {
            $provider = Provider::factory()->create(['enabled' => false]);

            $response = $this->postJson("/api/providers/{$provider->id}/toggle");

            $response->assertOk()
                ->assertJson(['enabled' => true]);

            expect($provider->fresh()->enabled)->toBeTrue();
        });

        it('toggles provider multiple times', function () {
            $provider = Provider::factory()->create(['enabled' => true]);

            $this->postJson("/api/providers/{$provider->id}/toggle");
            expect($provider->fresh()->enabled)->toBeFalse();

            $this->postJson("/api/providers/{$provider->id}/toggle");
            expect($provider->fresh()->enabled)->toBeTrue();

            $this->postJson("/api/providers/{$provider->id}/toggle");
            expect($provider->fresh()->enabled)->toBeFalse();
        });

        it('preserves other provider attributes when toggling', function () {
            $provider = Provider::factory()->create([
                'name' => 'TestProvider',
                'enabled' => true,
            ]);

            $originalName = $provider->name;
            $originalCreatedAt = $provider->created_at;

            $this->postJson("/api/providers/{$provider->id}/toggle");

            $provider->refresh();

            expect($provider->name)->toBe($originalName)
                ->and($provider->created_at->eq($originalCreatedAt))->toBeTrue();
        });
    });

    describe('error handling', function () {
        it('returns 404 for non-existent provider id', function () {
            $response = $this->postJson('/api/providers/999999/toggle');

            $response->assertNotFound()
                ->assertJson(['message' => 'Provider not found']);
        });

        it('returns 404 for negative provider id', function () {
            $response = $this->postJson('/api/providers/-1/toggle');

            $response->assertNotFound()
                ->assertJson(['message' => 'Provider not found']);
        });
    });
});
