<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $categories = [
            'engine',
            'suspension',
            'brakes',
            'electronics',
            'filters'
        ];

        return [
            'name' => $this->faker->words(3, true),
            'sku' => strtoupper(Str::random(10)),
            'price' => $this->faker->randomFloat(2, 10, 500),
            'stock_quantity' => $this->faker->numberBetween(0, 200),
            'category' => $this->faker->randomElement($categories),
        ];
    }
}
