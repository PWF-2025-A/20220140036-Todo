<?php



namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->word,  // Ganti name menjadi title
            'user_id' => User::factory(),  // Asumsikan user_id dibuat menggunakan factory User
        ];
    }
}
