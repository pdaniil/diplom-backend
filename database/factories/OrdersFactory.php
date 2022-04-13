<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class OrdersFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'receive_time' => Date(now()),
            'chat_created' => rand(0,1),
        ];
    }
}
