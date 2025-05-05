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
                'price' => 50.00,
                'icon' => 'map-marker-alt'
            ],
            [
                'name' => 'Child Seat',
                'price' => 30.00,
                'icon' => 'baby'
            ],
            [
                'name' => 'Wi-Fi Hotspot',
                'price' => 25.00,
                'icon' => 'wifi'
            ],
            [
                'name' => 'Driver Service',
                'price' => 200.00,
                'icon' => 'user-tie'
            ],
        ];

        foreach ($specifications as $spec) {
            Specification::firstOrCreate(
                ['name' => $spec['name']],
                [
                    'price' => $spec['price'],
                    'icon' => $spec['icon']
                ]
            );
        }
    }
}
