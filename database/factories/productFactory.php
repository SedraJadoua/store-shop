<?php

namespace Database\Factories;

use App\Models\color;
use App\Models\type;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\product>
 */
class productFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
        'name' => fake()->name(),
        'size' => fake()->numberBetween(0,5),
        'total_amount' => fake()->numberBetween(10, 10000),
        'prod_detail' =>fake()->paragraph(),
        'color_id'=>fake()->numberBetween(0 , 8),
        'store_id'=>fake()->numberBetween(0 , 1),
        'type_id'=> type::factory(),
        'photo' => fake()->image(),
        'price'=>fake()->numberBetween(100,100000),
        ];
    }
}
