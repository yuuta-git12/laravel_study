<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Author;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AuthorDetail>
 */
class AuthorDetailFactory extends Factory
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
            'author_id' => Author::factory(),   // 著者ID 型:int 外部キー テーブル名:authors
            'email' => fake()->unique()->safeEmail(), // メールアドレス 型:varchar(100) ユニーク
            'address' => fake()->address(), // 住所 型:varchar(100)
        ];
    }
}
