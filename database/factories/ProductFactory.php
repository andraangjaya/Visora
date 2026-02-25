<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        return [
            'product_name' => fake()->words(2, true),
            'product_price' => fake()->numberBetween(10000, 1000000),
            'product_stock' => fake()->numberBetween(0, 100),
            'product_description' => fake()->sentence(),
        ];
    }
}
