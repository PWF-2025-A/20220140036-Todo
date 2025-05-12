<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Todo;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Periksa jika user admin sudah ada
        if (!User::where('email', 'admin@admin.com')->exists()) {
            // Buat 1 admin user
            User::create([
                'name' => 'Admin',
                'email' => 'admin@admin.com',
                'email_verified_at' => now(),
                'password' => Hash::make('admin'),
                'remember_token' => Str::random(10),
                'is_admin' => true,
            ]);
        }

        // Buat 100 user biasa
        User::factory(10)->create();

        // Buat kategori terlebih dahulu
        $categories = Category::factory(10)->create(); // Membuat 10 kategori
        
        // Tambahkan kategori 'empty'
Category::create([
    'title' => 'empty',
    'user_id' => User::first()->id, // Menambahkan user_id
]);

        // Kemudian buat Todo, biarkan factory menangani relasi dengan category_id dan user_id
        Todo::factory(10)->create();
    }
}
