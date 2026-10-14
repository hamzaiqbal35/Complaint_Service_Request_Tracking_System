<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\User;
use Database\Seeders\AdminSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminSeederTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_seeder_creates_default_admin_and_categories(): void
    {
        $this->seed(AdminSeeder::class);

        $this->assertDatabaseHas('users', [
            'email' => 'admin@example.com',
            'role' => 'admin',
        ]);

        $admin = User::where('email', 'admin@example.com')->first();
        $this->assertNotNull($admin);
        $this->assertTrue(Hash::check('password', $admin->password));
        $this->assertNotNull($admin->email_verified_at);

        // Check categories exist
        $this->assertTrue(Category::where('slug', 'it')->exists());
        $this->assertTrue(Category::where('slug', 'electrical')->exists());
    }

    public function test_admin_seeder_supports_custom_env_variables(): void
    {
        putenv('ADMIN_EMAIL=superadmin@custom.org');
        putenv('ADMIN_PASSWORD=SuperSecretPass123!');

        $this->seed(AdminSeeder::class);

        $this->assertDatabaseHas('users', [
            'email' => 'superadmin@custom.org',
            'role' => 'admin',
        ]);

        $admin = User::where('email', 'superadmin@custom.org')->first();
        $this->assertNotNull($admin);
        $this->assertTrue(Hash::check('SuperSecretPass123!', $admin->password));

        // Clean up
        putenv('ADMIN_EMAIL');
        putenv('ADMIN_PASSWORD');
    }
}
