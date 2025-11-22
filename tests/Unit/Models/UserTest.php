<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

describe('User Model', function () {
    it('has fillable attributes', function () {
        $user = new User([
            'name' => 'John Doe',
            'email' => 'john@example.com',
        ]);

        expect($user->name)->toBe('John Doe')
            ->and($user->email)->toBe('john@example.com');
    });

    it('has hidden attributes', function () {
        $user = User::factory()->create([
            'password' => 'secret',
            'remember_token' => 'token123',
        ]);

        $array = $user->toArray();

        expect($array)->not->toHaveKey('password')
            ->and($array)->not->toHaveKey('remember_token');
    });

    it('has a factory', function () {
        $user = User::factory()->create();

        expect($user->name)->toBeString()
            ->and($user->email)->toBeString()
            ->and($user->password)->toBeString()
            ->and($user)->toBeInstanceOf(User::class);
    });

    it('casts email_verified_at to datetime', function () {
        $user = User::factory()->create([
            'email_verified_at' => '2024-01-01 12:00:00',
        ]);

        expect($user->email_verified_at)->toBeInstanceOf(\Illuminate\Support\Carbon::class);
    });

    it('hashes password on creation', function () {
        $user = User::factory()->create([
            'password' => 'plain-text-password',
        ]);

        expect($user->password)->not->toBe('plain-text-password')
            ->and(strlen($user->password))->toBeGreaterThan(20);
    });

    it('can be created with valid data', function () {
        $userData = [
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'password' => bcrypt('password'),
        ];

        $user = User::create($userData);

        expect($user)->toBeInstanceOf(User::class)
            ->and($user->name)->toBe('Jane Doe')
            ->and($user->email)->toBe('jane@example.com');
    });

    it('uses notifiable trait', function () {
        $user = User::factory()->create();

        expect(method_exists($user, 'notify'))->toBeTrue()
            ->and(method_exists($user, 'notifyNow'))->toBeTrue();
    });
});
