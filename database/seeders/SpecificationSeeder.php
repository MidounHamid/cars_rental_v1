<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Specification;

class SpecificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $specifications = [
            [
                'name' => 'GPS Navigation',
                'price' => 50.00            ],
            [
                'name' => 'Child Seat',
                'price' => 30.00,
            ],
            [
                'name' => 'Wi-Fi Hotspot',
                'price' => 25.00,
            ],
            [
                'name' => 'Driver Service',
                'price' => 200.00,
            ],
        ];

        foreach ($specifications as $spec) {
            Specification::firstOrCreate(
                ['name' => $spec['name']],
                [
                    'price' => $spec['price'],
                ]
            );
        }
    }
}
