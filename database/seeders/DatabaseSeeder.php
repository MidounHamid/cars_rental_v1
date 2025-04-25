<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Car;
use App\Models\CarType;
use App\Models\Brand;
use App\Models\FuelType;
use App\Models\Insurance;
use App\Models\Agency;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Créer des données pour les tables de référence
        \App\Models\CarType::factory(10)->create();
        \App\Models\Brand::factory(10)->create();
        \App\Models\FuelType::factory(10)->create();
        \App\Models\Insurance::factory(10)->create();
        \App\Models\Agency::factory(10)->create();

        // Créer des voitures en utilisant les données des tables de référence
        \App\Models\Car::factory(10)->create();
    }
}
