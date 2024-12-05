<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sgo_products')->insert([
            [
                'name' => 'Máy phát điện chạy xăng elemax SH1900',
                'slug' => 'may-phat-dien-elemax-sh1900',
                'price' => 4500000,  // Có giá
                'quantity' => 50,
                'category_id' => 1,  // Máy phát điện
                'description_short' => 'Máy phát điện chạy xăng Elemax SH1900 chất lượng cao.',
                'description' => 'Máy phát điện Elemax SH1900 với động cơ mạnh mẽ, tiết kiệm nhiên liệu, phù hợp cho các nhu cầu sử dụng tại các công trình ngoài trời.',
                'promotions_id' => 1, // Giảm giá 10%
                'origin_id' => 1, // Xuất xứ Nhật Bản
                'fuel_id' => 1, // Nhiên liệu Xăng
                'title_seo' => 'Máy phát điện Elemax SH1900 - Chạy xăng',
                'description_seo' => 'Máy phát điện Elemax SH1900 chạy xăng, tiết kiệm nhiên liệu, chất lượng cao, sử dụng cho mọi nhu cầu.',
                'keyword_seo' => 'máy phát điện, elemax, SH1900, chạy xăng, tiết kiệm nhiên liệu',
            ],
            [
                'name' => 'Máy Phát Điện Chạy Xăng Elemax SV2800',
                'slug' => 'may-phat-dien-elemax-sv2800',
                'price' => 5000000,  // Có giá
                'quantity' => 30,
                'category_id' => 1,  // Máy phát điện
                'description_short' => 'Máy phát điện Elemax SV2800 chạy xăng.',
                'description' => 'Máy phát điện Elemax SV2800 với động cơ xăng mạnh mẽ, tiết kiệm nhiên liệu, dễ sử dụng.',
                'promotions_id' => 2, // Giảm giá 15%
                'origin_id' => 1, // Xuất xứ Nhật Bản
                'fuel_id' => 1, // Nhiên liệu Xăng
                'title_seo' => 'Máy phát điện Elemax SV2800',
                'description_seo' => 'Máy phát điện Elemax SV2800 chạy xăng, công suất mạnh mẽ, tiết kiệm nhiên liệu.',
                'keyword_seo' => 'máy phát điện, elemax, SV2800, chạy xăng, công suất mạnh mẽ',
            ],
            [
                'name' => 'Máy Phát Điện Chạy Xăng Elemax SV2800S',
                'slug' => 'may-phat-dien-elemax-sv2800s',
                'price' => 5200000,  // Có giá
                'quantity' => 25,
                'category_id' => 1,  // Máy phát điện
                'description_short' => 'Máy phát điện Elemax SV2800S chạy xăng, hiệu suất cao.',
                'description' => 'Máy phát điện Elemax SV2800S với công suất cao, tiết kiệm nhiên liệu, phù hợp cho các khu vực cần nguồn điện ổn định.',
                'promotions_id' => 0, // Không có khuyến mãi
                'origin_id' => 1, // Xuất xứ Nhật Bản
                'fuel_id' => 1, // Nhiên liệu Xăng
                'title_seo' => 'Máy phát điện Elemax SV2800S',
                'description_seo' => 'Máy phát điện Elemax SV2800S chạy xăng, hiệu suất cao, bền bỉ.',
                'keyword_seo' => 'máy phát điện, elemax, SV2800S, chạy xăng, hiệu suất cao',
            ],
            [
                'name' => 'Máy Phát Điện Chạy Xăng Elemax SV3300',
                'slug' => 'may-phat-dien-elemax-sv3300',
                'price' => 5500000,  // Có giá
                'quantity' => 40,
                'category_id' => 1,  // Máy phát điện
                'description_short' => 'Máy phát điện Elemax SV3300 chạy xăng, công suất mạnh mẽ.',
                'description' => 'Máy phát điện Elemax SV3300 với công suất mạnh mẽ, tiết kiệm nhiên liệu, đáp ứng nhu cầu sử dụng trong công việc và sinh hoạt.',
                'promotions_id' => 1, // Giảm giá 10%
                'origin_id' => 1, // Xuất xứ Nhật Bản
                'fuel_id' => 1, // Nhiên liệu Xăng
                'title_seo' => 'Máy phát điện Elemax SV3300',
                'description_seo' => 'Máy phát điện Elemax SV3300 chạy xăng, công suất mạnh mẽ, bền bỉ.',
                'keyword_seo' => 'máy phát điện, elemax, SV3300, chạy xăng, công suất mạnh mẽ',
            ],
            [
                'name' => 'Máy Nén Khí W3.5/5',
                'slug' => 'may-nen-khi-w3-5-5',
                'price' => null, // Không có giá
                'quantity' => 10,
                'category_id' => 2,  // Máy nén khí
                'description_short' => 'Máy nén khí W3.5/5 công suất lớn.',
                'description' => 'Máy nén khí W3.5/5 với công suất lớn, đáp ứng các nhu cầu công nghiệp và xây dựng.',
                'promotions_id' => 0, // Không có khuyến mãi
                'origin_id' => 3, // Xuất xứ Trung Quốc
                'fuel_id' => 2, // Nhiên liệu Dầu Diesel
                'title_seo' => 'Máy nén khí W3.5/5',
                'description_seo' => 'Máy nén khí W3.5/5, công suất lớn, đáp ứng nhu cầu công nghiệp.',
                'keyword_seo' => 'máy nén khí, W3.5/5, công suất lớn, dầu diesel',
            ],
            [
                'name' => 'Máy Nén Khí W2.8/5',
                'slug' => 'may-nen-khi-w2-8-5',
                'price' => 2000000,  // Có giá
                'quantity' => 5,
                'category_id' => 2,  // Máy nén khí
                'description_short' => 'Máy nén khí W2.8/5, công suất vừa phải.',
                'description' => 'Máy nén khí W2.8/5 với công suất vừa phải, phù hợp cho các công trình nhỏ và vừa.',
                'promotions_id' => 2, // Giảm giá 15%
                'origin_id' => 3, // Xuất xứ Trung Quốc
                'fuel_id' => 2, // Nhiên liệu Dầu Diesel
                'title_seo' => 'Máy nén khí W2.8/5',
                'description_seo' => 'Máy nén khí W2.8/5, công suất vừa phải, tiết kiệm nhiên liệu.',
                'keyword_seo' => 'máy nén khí, W2.8/5, công suất vừa phải, dầu diesel',
            ],
            [
                'name' => 'Máy Nổ – Động Cơ Xăng Honda GX200T2 CHB2 6.5HP',
                'slug' => 'dong-co-xang-honda-gx200t2',
                'price' => 3500000,  // Có giá
                'quantity' => 10,
                'category_id' => 3,  // Các loại động cơ
                'description_short' => 'Động cơ xăng Honda GX200T2 6.5HP chất lượng.',
                'description' => 'Động cơ Honda GX200T2 6.5HP là sự lựa chọn tuyệt vời cho các thiết bị công nghiệp và nông nghiệp, công suất mạnh mẽ và bền bỉ.',
                'promotions_id' => 1, // Giảm giá 10%
                'origin_id' => 1, // Xuất xứ Nhật Bản
                'fuel_id' => 1, // Nhiên liệu Xăng
                'title_seo' => 'Động cơ xăng Honda GX200T2 6.5HP',
                'description_seo' => 'Động cơ Honda GX200T2 6.5HP, công suất mạnh mẽ, bền bỉ.',
                'keyword_seo' => 'động cơ xăng, Honda, GX200T2, 6.5HP, công suất mạnh mẽ',
            ],
            // Thêm các sản phẩm còn lại tương tự
        ]);
    }
}
