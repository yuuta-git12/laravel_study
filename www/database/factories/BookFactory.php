<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Category;
use App\Models\Admin;

/**
 * 書籍ファクトリー
 *
 * テスト・シーディング用にBookモデルのダミーデータを生成するファクトリー
 *
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    /**
     * モデルのデフォルト状態を定義する
     *
     * fake()ヘルパーでランダムなダミーデータを生成し、
     * 外部キー（category_id・admin_id）は各モデルのファクトリーを使って自動生成する
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
            'title' => fake()->realText(15), // タイトル 型:varchar(100)
            'price' => fake()->numberBetween(500,20000), // 価格 型:int
            'category_id' => Category::factory(),// カテゴリID 型:int 外部キー テーブル名:categories
            'admin_id' => Admin::factory(),// 管理者ID 型:int 外部キー テーブル名:admins
        ];
    }
}
