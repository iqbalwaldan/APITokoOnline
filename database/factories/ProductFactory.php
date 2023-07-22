<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

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
        return [
            'name' => $this->faker->unique()->sentence(mt_rand(2,3)),
            'price' => $this->faker->numberBetween($min = 1500, $max = 6000),
            'qty' => $this->faker->numberBetween($min = 50, $max = 100)
        ];
    }
}
