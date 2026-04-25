<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin::factory()->create()：AdminFactoryの定義をベースに、指定した値で上書きしてレコードを生成・保存する
        // Hash::make()：平文パスワードをbcryptでハッシュ化する（DBには必ずハッシュ値を保存する）

        Admin::factory()->create([
            'name' => 'sano',
            'login_id' => 'sano_id',
            'password' => Hash::make('hogehoge@12'),
        ]);

        Admin::factory()->create([
            'name' => 'sato',
            'login_id' => 'sato_id',
            'password' => Hash::make('fugafuga@12'),
        ]);

        Admin::factory()->create([
            'name' => 'admin',
            'login_id' => 'admin@example.com',
            'password' => Hash::make('password@12'),
        ]);
    }
}
