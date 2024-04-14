<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $categoryIds = Category::query()->pluck('id')->toArray();
        return [
            'category_id' => $this->faker->numberBetween(min($categoryIds), max($categoryIds)),
            'slug' => $this->faker->slug,
            'name' => $this->faker->words(3, true),
            'price' => $this->faker->numberBetween(100, 10000),
            'stock' => $this->faker->numberBetween(0, 100),
            'description' => $this->faker->paragraphs(2, true),
            'is_published' => $this->faker->boolean(),
        ];
    }
}
