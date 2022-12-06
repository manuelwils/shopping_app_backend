<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->company,
            'description' => $this->faker->text,
            'amount' => $this->faker->randomFloat(null, 2000.00, 10000.00),
            'image' => 'https://www.nairaland.com/attachments/16535107_fbimg16610297469840949_jpeg73c0b236b7a048b130b6b0cbd11a4352',
            'favorite' => $this->faker->boolean,            
        ];
    }
}
