<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Todo; // ✅ Import Todo model
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash; // ✅ Import Hash
use Illuminate\Support\Str; // ✅ Import Str

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Buat 1 admin user
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'email_verified_at' => now(),
            'password' => Hash::make('admin'),
            'remember_token' => Str::random(10),
            'is_admin' => true,
        ]);

        // Buat 100 user biasa
        User::factory(100)->create();

        // Buat 100 todo
        Todo::factory(500)->create();
    }
}
