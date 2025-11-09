<?php

use App\Models\Bin;
use App\Models\Provider;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

describe('Provider Model Edge Cases', function () {
    it('has many bins relationship', function () {
        $provider = Provider::factory()->create();
        Bin::factory()->count(3)->create(['provider_id' => $provider->id]);

        expect($provider->bins)->toHaveCount(3);
    });

    it('can be enabled or disabled', function () {
        $enabledProvider = Provider::factory()->create(['enabled' => true]);
        $disabledProvider = Provider::factory()->create(['enabled' => false]);

        expect($enabledProvider->enabled)->toBeTrue()
            ->and($disabledProvider->enabled)->toBeFalse();
    });

    it('can toggle enabled status', function () {
        $provider = Provider::factory()->create(['enabled' => true]);

        $provider->enabled = false;
        $provider->save();

        expect($provider->fresh()->enabled)->toBeFalse();

        $provider->enabled = true;
        $provider->save();

        expect($provider->fresh()->enabled)->toBeTrue();
    });

    it('can filter enabled providers', function () {
        Provider::factory()->create(['enabled' => true, 'name' => 'Enabled1']);
        Provider::factory()->create(['enabled' => true, 'name' => 'Enabled2']);
        Provider::factory()->create(['enabled' => false, 'name' => 'Disabled']);

        $enabledProviders = Provider::where('enabled', true)->get();

        expect($enabledProviders)->toHaveCount(2);
    });

    it('cannot delete provider with associated bins due to foreign key constraint', function () {
        $provider = Provider::factory()->create();
        Bin::factory()->count(3)->create(['provider_id' => $provider->id]);

        expect(Bin::where('provider_id', $provider->id)->count())->toBe(3);

        expect(fn () => $provider->delete())
            ->toThrow(\Illuminate\Database\QueryException::class);

        expect(Provider::find($provider->id))->not->toBeNull();
    });

    it('stores provider name correctly', function () {
        $provider = Provider::factory()->create(['name' => 'TestProvider']);

        expect($provider->name)->toBe('TestProvider');
    });

    it('has timestamps', function () {
        $provider = Provider::factory()->create();

        expect($provider->created_at)->not->toBeNull()
            ->and($provider->updated_at)->not->toBeNull()
            ->and($provider->created_at)->toBeInstanceOf(\Illuminate\Support\Carbon::class)
            ->and($provider->updated_at)->toBeInstanceOf(\Illuminate\Support\Carbon::class);
    });

    it('can update provider attributes', function () {
        $provider = Provider::factory()->create([
            'name' => 'OriginalName',
            'enabled' => true,
        ]);

        $provider->update([
            'name' => 'UpdatedName',
            'enabled' => false,
        ]);

        expect($provider->fresh()->name)->toBe('UpdatedName')
            ->and($provider->fresh()->enabled)->toBeFalse();
    });
});
