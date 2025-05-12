<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
use App\Models\Todo;
use Illuminate\Database\Eloquent\Factories\Factory;

class TodoFactory extends Factory
{
    protected $model = Todo::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence,
            'is_done' => $this->faker->boolean,
            'user_id' => User::factory(), // Relasi ke User
            'category_id' => Category::factory(), // Relasi ke Category
        ];
    }
}
