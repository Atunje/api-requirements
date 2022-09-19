<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $title = fake()->sentence(rand(1,4));
        return [
            'sku' => rand(6,6),
            'name' => $title,
            'category' => fake()->randomElement(['insurance', 'vehicle']),
            'price' => rand(4,5),
        ];
    }
}
