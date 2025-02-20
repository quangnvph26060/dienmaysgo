<?php

namespace App\Console\Commands;

use App\Models\SgoProduct;
use Spatie\Sitemap\Sitemap;
use Illuminate\Console\Command;
use Spatie\Sitemap\Tags\Url;

class GenerateSitemap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemap:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate the sitemap for products.';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $sitemap = Sitemap::create();

        // Lấy danh sách sản phẩm
        $products = SgoProduct::query()->with('category')->whereNotNull('category_id')->get();

        foreach ($products as $product) {
            // Thêm URL sản phẩm vào sitemap
            $sitemap->add(Url::create(route('products.detail', ['catalogue' => $product->category->slug, 'slug' => $product->slug]))
                ->setLastModificationDate($product->updated_at)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
                ->setPriority(0.8));
        }

        // Lưu sitemap vào file
        $sitemap->writeToFile(public_path('sitemap.xml'));

        $this->info('Sitemap has been generated!');
    }
}
