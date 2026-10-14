<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

/**
 * ============================================================================
 * ADMIN CREDENTIALS
 * ============================================================================
 * Email:    admin@example.com   (Override via ADMIN_EMAIL environment variable)
 * Password: password            (Override via ADMIN_PASSWORD environment variable)
 * Role:     admin
 * Status:   Email Verified
 * ============================================================================
 * 
 * HOW TO USE ON RENDER:
 * 1. In Render Dashboard -> csrts-app -> Environment -> Add/Edit:
 *    - SEED_ADMIN    = true
 *    - ADMIN_EMAIL   = your_admin_email@example.com   (optional, defaults to admin@example.com)
 *    - ADMIN_PASSWORD= your_secure_password           (optional, defaults to password)
 * 2. Deploy your application. The entrypoint will run this seeder once.
 * 3. Log in with the credentials above.
 * 4. In Render Dashboard, set SEED_ADMIN to false (or remove it).
 * ============================================================================
 */
class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // Read from environment variables if defined, otherwise fallback to defaults
        $email = env('ADMIN_EMAIL') 
            ?: (getenv('ADMIN_EMAIL') ?: ($_ENV['ADMIN_EMAIL'] ?? 'admin@example.com'));
        $password = env('ADMIN_PASSWORD') 
            ?: (getenv('ADMIN_PASSWORD') ?: ($_ENV['ADMIN_PASSWORD'] ?? 'password'));

        // Avoid resetting passwords or creating duplicates for an existing account
        $existing = User::where('email', $email)->first();
        if ($existing) {
            $this->command->warn(
                "Account [{$email}] already exists; no changes made."
            );
        } else {
            $user = new User();
            $user->name = 'Admin';
            $user->email = $email;
            $user->password = Hash::make($password);
            $user->role = 'admin';
            $user->email_verified_at = now();
            $user->save();

            $this->command->info("Admin account created successfully with email [{$email}].");
        }

        // Ensure default system categories exist
        $categories = ['IT', 'Electrical', 'HR', 'Maintenance', 'Plumbing', 'Security'];
        foreach ($categories as $name) {
            Category::firstOrCreate(
                ['slug' => str($name)->slug()],
                ['name' => $name]
            );
        }
        $this->command->info('Default categories verified/created.');
    }
}
