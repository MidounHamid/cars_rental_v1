<?php

namespace Database\Seeders;

use App\Models\CarType;
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

        // Seed fixed unique car types
        $carTypes = ['SUV', 'Sedan', 'Coupe', 'Hatchback', 'Convertible', 'Truck', 'Minivan'];

    foreach ($carTypes as $type) {
        CarType::firstOrCreate(['name' => $type], [
            'description' => fake()->text(100),
        ]);
    }


        // Create other models first
        \App\Models\Brand::factory(10)->create();
        \App\Models\Insurance::factory(10)->create();
        \App\Models\Agency::factory(10)->create();

        // Now create cars using existing relationships
        \App\Models\Car::factory(20)->create();
    }
}

