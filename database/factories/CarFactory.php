<?php

namespace Database\Factories;

use App\Models\Agency;
use App\Models\Brand;
use App\Models\CarType;
use App\Models\FuelType;
use App\Models\Insurance;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Car>
 */
class CarFactory extends Factory
{
    public function definition(): array
    {
        $carModels = [
            'Toyota Corolla',
            'Honda Civic',
            'BMW 3 Series',
            'Audi A4',
            'Tesla Model 3',
            'Ford Mustang',
            'Chevrolet Malibu',
            'Nissan Altima',
            'Mercedes-Benz C-Class',
        ];

        return [
            'model' => $this->faker->randomElement($carModels),
            'car_type_id' => CarType::inRandomOrder()->value('id'),
            'city' => $this->faker->city,
            'price_per_day' => $this->faker->randomFloat(2, 30, 150),
            'fuel_types_id' => FuelType::inRandomOrder()->value('id'),
            'transmission' => $this->faker->randomElement(['Automatic', 'Manual', 'CVT', 'Semi-Automatic']),
            'seats' => $this->faker->numberBetween(2, 7),
            'is_available' => true, // ✅ Always true by default

            'agency_id' => Agency::factory(),
            'brand_id' => Brand::factory(),
            'insurance_id' => Insurance::factory(),
        ];
    }
}
