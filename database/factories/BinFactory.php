<?php

namespace Database\Factories;

use App\Models\Provider;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Bin>
 */
class BinFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'bin' => fake()->unique()->numerify('######'),
            'type' => fake()->randomElement(['debit', 'credit']),
            'brand' => fake()->creditCardType(),
            'bank' => fake()->company,
            'country' => fake()->countryCode,
            'provider_id' => function () {
                return Provider::factory()->create()->id;
            },
        ];
    }
}
