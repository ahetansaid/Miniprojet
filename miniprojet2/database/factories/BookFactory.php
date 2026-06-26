<?php

namespace Database\Factories;

use App\Models\Book;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Category;


/**
 * @extends Factory<Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    
public function definition(): array
{
    return [
        'title' => $this->faker->sentence(3),
        'author' => $this->faker->name(),
        'isbn' => $this->faker->unique()->isbn13(),
        'available_copies' => $this->faker->numberBetween(1, 10),
        'category_id' => Category::inRandomOrder()->first()->id ?? Category::factory(),
    ];
}
}
