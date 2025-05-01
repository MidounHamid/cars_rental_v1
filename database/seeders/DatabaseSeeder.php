<?php

namespace Database\Seeders;

use App\Models\FuelType;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Seed fixed unique fuel types
        $fuelTypes = ['Petrol', 'Diesel', 'Electric', 'Hybrid'];
        foreach ($fuelTypes as $type) {
            FuelType::firstOrCreate(['fuel_type' => $type]);
        }

        // Other factories
        \App\Models\CarType::factory(10)->create();
        \App\Models\Brand::factory(10)->create();
        \App\Models\Insurance::factory(10)->create();
        \App\Models\Agency::factory(10)->create();

        // Car factory should use existing fuel types
        \App\Models\Car::factory(20)->create();
    }
}

