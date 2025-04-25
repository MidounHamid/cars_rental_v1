<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Agency>
 */
class AgencyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->company,
            'city' => $this->faker->city,
            'address' => $this->faker->address,
            'phone' => $this->faker->phoneNumber,
            'logo' => $this->faker->imageUrl,
        ];
    }
}
