<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->title(),
            'price' => $this->faker->randomNumber(5),
            'image' => 'image.png',
            'description' => $this->faker->text(200),
            'stock' => $this->faker->randomNumber(5),
            'status' => true,

        ];
    }
}
