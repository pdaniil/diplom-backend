<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CustomersFactory extends Factory
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
            'login' => $this->faker->unique()->safeEmail(),
            'password' => md5('zxcZXC123'), // password
            'is_admin' => rand(0,1)
        ];
    }
}
