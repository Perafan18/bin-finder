<?php

namespace Database\Seeders;

use App\Models\Provider;
use Illuminate\Database\Seeder;

class ProviderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Provider::create(['name' => 'binlist', 'enabled' => true]);
        Provider::create(['name' => 'bincodes', 'enabled' => true]);
        Provider::create(['name' => 'bincheck', 'enabled' => true]);
        Provider::create(['name' => 'greip', 'enabled' => true]);
        Provider::create(['name' => 'iinlist', 'enabled' => true]);
    }
}
