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
            'name' => $this->faker->name(),
            'description' => $this->faker->paragraph(2),
            'price' => $this->faker->randomFloat(2, 10, 1000) ,
            'image' => $this->faker->imageUrl()
        ];
    }
}
