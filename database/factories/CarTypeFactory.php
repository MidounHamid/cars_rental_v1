<?php

namespace Database\Factories;

use App\Models\CarType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CarType>
 */
class CarTypeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $carTypes = ['SUV', 'Sedan', 'Coupe', 'Hatchback', 'Convertible', 'Truck', 'Minivan'];

        return [
            'name' => $this->faker->randomElement($carTypes),  // Choose from predefined car types
            'description' => $this->faker->text(100),  // Shorter description for realism
        ];
    }
}
