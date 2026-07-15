<?php

namespace Database\Factories;

use App\Models\Complaint;
use App\Models\ComplaintLog;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ComplaintLog>
 */
class ComplaintLogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'complaint_id' => Complaint::factory(),
            'user_id' => User::factory(),
            'action' => 'created',
            'message' => $this->faker->sentence(),
            'meta' => [],
        ];
    }
}
