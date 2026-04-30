<?php

namespace Database\Factories;

use App\Models\Author;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title'       => fake()->sentence(3),    // Random title
            'author_id'   => Author::factory(),      // Auto Author create
            'category_id' => Category::factory(),    // Auto Category create
            'quantity'    => fake()->numberBetween(1, 20), // 1-20 random number
            'isbn'        => fake()->isbn13(),        // Random ISBN
        ];
    }
}