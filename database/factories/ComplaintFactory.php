<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ComplaintFactory extends Factory
{
    public function definition(): array
    {
        $creator = User::factory()->create(['role' => 'user']);
        $assigned = fake()->boolean(60) ? User::factory()->create(['role' => 'staff']) : null;
        $status = $assigned ? fake()->randomElement(['pending','in_progress','resolved']) : 'pending';
        return [
            'category_id' => Category::inRandomOrder()->value('id') ?? Category::factory(),
            'created_by' => $creator->id,
            'assigned_to' => $assigned?->id,
            'title' => fake()->sentence(6),
            'description' => fake()->paragraph(),
            'priority' => fake()->randomElement(['low','medium','high']),
            'status' => $status,
            'resolved_at' => $status === 'resolved' ? now()->subDays(rand(0,5)) : null,
        ];
    }
}


