<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Car>
 */
class CarFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'model' => $this->faker->word,
            'car_type_id' => \App\Models\CarType::factory(),
            'city' => $this->faker->city,
            'price_per_day' => $this->faker->randomFloat(2, 20, 200),
            'fuel_types_id' => \App\Models\FuelType::factory(),
            'transmission' => $this->faker->randomElement(['Automatic', 'Manual', 'CVT', 'Semi-Automatic']),
            'seats' => $this->faker->numberBetween(2, 7),
            'is_available' => $this->faker->boolean,
            'agency_id' => \App\Models\Agency::factory(),
            'brand_id' => \App\Models\Brand::factory(),
            'insurance_id' => \App\Models\Insurance::factory(),
        ];
    }
}
