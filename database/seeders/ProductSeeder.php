<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = [
            [
                'product_name' => fake()->words(3, true),
                'description' => fake()->paragraph(),
                'price' => fake()->randomFloat(2, 5, 500),
            ],
            [
                'product_name' => fake()->words(3, true),
                'description' => fake()->paragraph(),
                'price' => fake()->randomFloat(2, 5, 500),
            ],
            [
                'product_name' => fake()->words(3, true),
                'description' => fake()->paragraph(),
                'price' => fake()->randomFloat(2, 5, 500),
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
