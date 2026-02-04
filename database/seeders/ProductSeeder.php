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
        $faker = \Faker\Factory::create();

        $products = [
            [
                'product_name' => $faker->words(3, true),
                'description' => $faker->paragraph(),
                'price' => $faker->randomFloat(2, 5, 500),
            ],
            [
                'product_name' => $faker->words(3, true),
                'description' => $faker->paragraph(),
                'price' => $faker->randomFloat(2, 5, 500),
            ],
            [
                'product_name' => $faker->words(3, true),
                'description' => $faker->paragraph(),
                'price' => $faker->randomFloat(2, 5, 500),
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
