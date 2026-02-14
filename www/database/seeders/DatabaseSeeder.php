<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        // CategoriesTableSeederを呼び出す
        // $this->call(CategoriesTableSeeder::class);
        // AuthorsTableSeederを呼び出す
        // $this->call(AuthorsTableSeeder::class);
        // BooksTableSeederを呼び出す
        // $this->call(BooksTableSeeder::class);

        // 複数のシーダーを呼び出す
        $this->call([
            AuthorsTableSeeder::class,
            BooksTableSeeder::class,
            AuthorBookTableSeeder::class,
        ]);
    }
}
