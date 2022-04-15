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
            'image' => $this->faker->image('public/storage/products_images', 400, 300),
            'description' => $this->faker->text(200),
            'stock' => $this->faker->randomNumber(5),
            'status' => true,

        ];
    }
}
