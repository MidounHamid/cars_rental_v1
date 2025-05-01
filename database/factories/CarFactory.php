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
        $carModels = [
            'Toyota Corolla',
            'Honda Civic',
            'BMW 3 Series',
            'Audi A4',
            'Tesla Model 3',
            'Ford Mustang',
            'Chevrolet Malibu',
            'Nissan Altima',
            'Mercedes-Benz C-Class'
        ];

        return [
            'model' => $this->faker->randomElement($carModels),  // Randomly selects from a predefined list of car models
            'car_type_id' => \App\Models\CarType::inRandomOrder()->first()->id,
            'city' => $this->faker->city,
            'price_per_day' => $this->faker->randomFloat(2, 30, 150),  // Price range adjusted for realism
            'fuel_types_id' => \App\Models\FuelType::inRandomOrder()->first()->id,
            'transmission' => $this->faker->randomElement(['Automatic', 'Manual', 'CVT', 'Semi-Automatic']),
            'seats' => $this->faker->numberBetween(2, 7),
            'is_available' => $this->faker->boolean,
            'agency_id' => \App\Models\Agency::factory(),
            'brand_id' => \App\Models\Brand::factory(),
            'insurance_id' => \App\Models\Insurance::factory(),
            'available_from' => $this->faker->dateTimeBetween('now', '+1 year')->format('Y-m-d'), // Random date within the next year
            'available_to' => $this->faker->dateTimeBetween('+1 week', '+1 year')->format('Y-m-d'), // Random date after 'available_from'
        ];
    }
}
