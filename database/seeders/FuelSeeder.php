<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FuelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sgo_fuel')->insert([
            [
                'name' => 'Xăng',
                'slug' => 'xang',
                'description' => 'Nhiên liệu xăng dùng cho các loại máy phát điện và động cơ.',
            ],
            [
                'name' => 'Dầu Diesel',
                'slug' => 'dau-diesel',
                'description' => 'Nhiên liệu dầu diesel được sử dụng cho các máy phát điện và động cơ công nghiệp.',
            ],
            [
                'name' => 'Gas',
                'slug' => 'gas',
                'description' => 'Nhiên liệu gas sử dụng cho các máy phát điện và động cơ nhỏ gọn, tiết kiệm.',
            ],
        ]);
    }
}
