<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Brand>
 */
class BrandFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $brands = [
            'Toyota', 'Honda', 'BMW', 'Audi', 'Mercedes-Benz',
            'Tesla', 'Ford', 'Chevrolet', 'Nissan', 'Volkswagen'
        ];

        return [
            'brand' => $this->faker->randomElement($brands), // Randomly selects a car brand from the list
        ];
    }
}
