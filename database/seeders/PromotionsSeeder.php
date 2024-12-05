<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PromotionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sgo_promotions')->insert([
            [
                'name' => 'Giảm giá 10%',
                'slug' => 'giam-gia-10',
                'description' => 'Giảm giá 10% cho tất cả sản phẩm trong tháng này.',
                'discount' => 10,
                'start_date' => Carbon::now()->format('Y-m-d H:i:s'),
                'end_date' => Carbon::now()->addMonths(1)->format('Y-m-d H:i:s'),
                'status' => 'expired', // 1: Active, 0: Inactive
            ],
            [
                'name' => 'Giảm giá 15%',
                'slug' => 'giam-gia-15',
                'description' => 'Giảm giá 15% cho các sản phẩm mới.',
                'discount' => 15,
                'start_date' => Carbon::now()->format('Y-m-d H:i:s'),
                'end_date' => Carbon::now()->addWeeks(2)->format('Y-m-d H:i:s'),
                'status' => 'inactive', // 1: Active, 0: Inactive
            ],
            [
                'name' => 'Khuyến mãi 20%',
                'slug' => 'khuyen-mai-20',
                'description' => 'Khuyến mãi 20% cho các sản phẩm chọn lọc.',
                'discount' => 20,
                'start_date' => Carbon::now()->subWeeks(1)->format('Y-m-d H:i:s'),
                'end_date' => Carbon::now()->addMonths(3)->format('Y-m-d H:i:s'),
                'status' => 'active',
            ],
        ]);
    }
}
