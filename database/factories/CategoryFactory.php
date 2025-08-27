<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    public function definition(): array
    {
        $name = fake()->unique()->randomElement(['IT','Electrical','HR','Maintenance','Plumbing','Security']);
        return [
            'name' => $name,
            'slug' => str($name)->slug(),
        ];
    }
}


