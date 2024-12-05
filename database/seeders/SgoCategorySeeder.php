<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class SgoCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        // Dữ liệu cho "Máy phát điện"
        $parentCategory = DB::table('sgo_category')->insertGetId([
            'name' => 'Máy phát điện',
            'slug' => 'may-phat-dien',
            'description' => $faker->paragraph,
            'logo' => $faker->imageUrl,
            'category_parent_id' => null, // Cha của "Máy phát điện" là null
            'title_seo' => 'Máy phát điện - SEO Title',
            'description_seo' => 'Máy phát điện - SEO Description',
            'keyword_seo' => 'Máy phát điện, generator, điện'
        ]);

        // Dữ liệu con của "Máy phát điện"
        DB::table('sgo_category')->insert([
            [
                'name' => 'Máy phát điện Elemax',
                'slug' => 'may-phat-dien-elemax',
                'description' => $faker->sentence,
                'logo' => $faker->imageUrl,
                'category_parent_id' => $parentCategory,
                'title_seo' => 'Máy phát điện Elemax - SEO Title',
                'description_seo' => 'Máy phát điện Elemax - SEO Description',
                'keyword_seo' => 'Máy phát điện Elemax, Elemax, điện'
            ],
            [
                'name' => 'Máy phát điện Honda',
                'slug' => 'may-phat-dien-honda',
                'description' => $faker->sentence,
                'logo' => $faker->imageUrl,
                'category_parent_id' => $parentCategory,
                'title_seo' => 'Máy phát điện Honda - SEO Title',
                'description_seo' => 'Máy phát điện Honda - SEO Description',
                'keyword_seo' => 'Máy phát điện Honda, Honda, điện'
            ],
            [
                'name' => 'Máy phát điện Huyndai',
                'slug' => 'may-phat-dien-huyndai',
                'description' => $faker->sentence,
                'logo' => $faker->imageUrl,
                'category_parent_id' => $parentCategory,
                'title_seo' => 'Máy phát điện Huyndai - SEO Title',
                'description_seo' => 'Máy phát điện Huyndai - SEO Description',
                'keyword_seo' => 'Máy phát điện Huyndai, Huyndai, điện'
            ],
            [
                'name' => 'Máy phát điện Koop',
                'slug' => 'may-phat-dien-koop',
                'description' => $faker->sentence,
                'logo' => $faker->imageUrl,
                'category_parent_id' => $parentCategory,
                'title_seo' => 'Máy phát điện Koop - SEO Title',
                'description_seo' => 'Máy phát điện Koop - SEO Description',
                'keyword_seo' => 'Máy phát điện Koop, Koop, điện'
            ],
            [
                'name' => 'Máy phát điện Kubota',
                'slug' => 'may-phat-dien-kubota',
                'description' => $faker->sentence,
                'logo' => $faker->imageUrl,
                'category_parent_id' => $parentCategory,
                'title_seo' => 'Máy phát điện Kubota - SEO Title',
                'description_seo' => 'Máy phát điện Kubota - SEO Description',
                'keyword_seo' => 'Máy phát điện Kubota, Kubota, điện'
            ],
        ]);

        // Dữ liệu cho "Máy nén khí"
        $parentCategory2 = DB::table('sgo_category')->insertGetId([
            'name' => 'Máy nén khí',
            'slug' => 'may-nen-khi',
            'description' => $faker->paragraph,
            'logo' => $faker->imageUrl,
            'category_parent_id' => null,
            'title_seo' => 'Máy nén khí - SEO Title',
            'description_seo' => 'Máy nén khí - SEO Description',
            'keyword_seo' => 'Máy nén khí, compressor'
        ]);

        // Dữ liệu con của "Máy nén khí"
        DB::table('sgo_category')->insert([
            [
                'name' => 'Máy nén khí Pamu',
                'slug' => 'may-nen-khi-pamu',
                'description' => $faker->sentence,
                'logo' => $faker->imageUrl,
                'category_parent_id' => $parentCategory2,
                'title_seo' => 'Máy nén khí Pamu - SEO Title',
                'description_seo' => 'Máy nén khí Pamu - SEO Description',
                'keyword_seo' => 'Máy nén khí Pamu, Pamu, nén khí'
            ]
        ]);

        // Dữ liệu cho "Các loại động cơ"
        $parentCategory3 = DB::table('sgo_category')->insertGetId([
            'name' => 'Các loại động cơ',
            'slug' => 'cac-loai-dong-co',
            'description' => $faker->paragraph,
            'logo' => $faker->imageUrl,
            'category_parent_id' => null,
            'title_seo' => 'Các loại động cơ - SEO Title',
            'description_seo' => 'Các loại động cơ - SEO Description',
            'keyword_seo' => 'Động cơ, engine'
        ]);

        // Dữ liệu con của "Các loại động cơ"
        DB::table('sgo_category')->insert([
            [
                'name' => 'Động cơ Honda',
                'slug' => 'dong-co-honda',
                'description' => $faker->sentence,
                'logo' => $faker->imageUrl,
                'category_parent_id' => $parentCategory3,
                'title_seo' => 'Động cơ Honda - SEO Title',
                'description_seo' => 'Động cơ Honda - SEO Description',
                'keyword_seo' => 'Động cơ Honda, Honda, engine'
            ],
            [
                'name' => 'Động cơ Koop',
                'slug' => 'dong-co-koop',
                'description' => $faker->sentence,
                'logo' => $faker->imageUrl,
                'category_parent_id' => $parentCategory3,
                'title_seo' => 'Động cơ Koop - SEO Title',
                'description_seo' => 'Động cơ Koop - SEO Description',
                'keyword_seo' => 'Động cơ Koop, Koop, engine'
            ],
            [
                'name' => 'Động cơ Robin',
                'slug' => 'dong-co-robin',
                'description' => $faker->sentence,
                'logo' => $faker->imageUrl,
                'category_parent_id' => $parentCategory3,
                'title_seo' => 'Động cơ Robin - SEO Title',
                'description_seo' => 'Động cơ Robin - SEO Description',
                'keyword_seo' => 'Động cơ Robin, Robin, engine'
            ]
        ]);
    }
}
