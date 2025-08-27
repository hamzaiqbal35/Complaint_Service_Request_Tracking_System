<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Complaint;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        // Staff
        User::factory()->count(5)->create(['role' => 'staff']);

        // Users
        User::factory()->count(15)->create(['role' => 'user']);

        // Categories
        $names = ['IT','Electrical','HR','Maintenance','Plumbing','Security'];
        foreach ($names as $name) {
            Category::firstOrCreate(
                ['slug' => str($name)->slug()],
                ['name' => $name]
            );
        }

        // Complaints
        Complaint::factory()->count(40)->create();
    }
}
