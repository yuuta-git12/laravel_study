<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Category;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
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
            //
            'title' => fake()->realText(15), // タイトル 型:varchar(100)
            'price' => fake()->numberBetween(500,10000), // 価格 型:int
            'category_id' => Category::factory(),// カテゴリID 型:int 外部キー テーブル名:categories
        ];
    }
}
