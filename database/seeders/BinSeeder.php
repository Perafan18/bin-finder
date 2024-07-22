<?php

namespace Database\Seeders;

use App\Models\Provider;
use App\Models\Bin;
use Illuminate\Database\Seeder;

class BinSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Provider::all()->each(function (Provider $provider): void {
            $provider->bins()->saveMany(Bin::factory()->count(10)->make());
        });
    }
}
