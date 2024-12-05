<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OriginSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sgo_origin')->insert([
            [
                'name' => 'Nhật Bản',
                'slug' => 'nhat-ban',
                'description' => 'Sản phẩm xuất xứ từ Nhật Bản, nổi bật với chất lượng cao và độ bền vượt trội.',
            ],
            [
                'name' => 'Hàn Quốc',
                'slug' => 'han-quoc',
                'description' => 'Sản phẩm xuất xứ từ Hàn Quốc, được biết đến với công nghệ tiên tiến và giá thành hợp lý.',
            ],
            [
                'name' => 'Trung Quốc',
                'slug' => 'trung-quoc',
                'description' => 'Sản phẩm xuất xứ từ Trung Quốc, đa dạng về mẫu mã và giá cả phải chăng.',
            ],
            [
                'name' => 'Mỹ',
                'slug' => 'my',
                'description' => 'Sản phẩm xuất xứ từ Mỹ, nổi bật với chất lượng vượt trội và công nghệ tiên tiến.',
            ],
            [
                'name' => 'Châu Âu',
                'slug' => 'chau-au',
                'description' => 'Sản phẩm từ các quốc gia thuộc Châu Âu, có chất lượng cao và thiết kế tinh tế.',
            ],
        ]);
    }
}
