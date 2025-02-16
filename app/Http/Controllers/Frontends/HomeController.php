<?php

namespace App\Http\Controllers\Frontends;

use App\Models\SgoProduct;
use App\Models\SgoCategory;
use App\Models\Slider;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\HistorySearch;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    public function home()
    {

        // $categories = SgoCategory::all();
        // $products = SgoProduct::all();

        // foreach ($products as $product) {
        //     $bestMatch = null;
        //     $bestScore = 0;

        //     foreach ($categories as $category) {
        //         similar_text($product->name, $category->name, $percent);

        //         if ($percent > $bestScore) { // Nếu mức độ giống cao hơn mức trước đó
        //             $bestScore = $percent;
        //             $bestMatch = $category->id;
        //         }
        //     }

        //     if ($bestMatch) {
        //         $product->category_id = $bestMatch;
        //         $product->save();
        //     }
        // }

        // Cache danh mục cha
        $categories = Cache::remember('categories', now()->addMinutes(30), function () {
            return SgoCategory::whereNull('category_parent_id')->orderBy('location', 'asc')->get();
        });

        // Cache dữ liệu của trang chủ (danh mục cha, con và sản phẩm)
        $data = Cache::remember('home_data', now()->addMinutes(30), function () use ($categories) {
            return $categories->map(function ($category) {
                return [
                    'parent' => $category,
                    'childrens' => $this->getAllChildrens($category),
                    'products' => $this->getAllProducts($category),
                ];
            });
        });

        $images = Slider::query()->latest()->pluck('url', 'id')->toArray();

        // Xử lý tìm kiếm và sắp xếp sản phẩm
        $query = SgoProduct::query();

        if (request('s')) {
            HistorySearch::insert(request('s'));
            return redirect()->route('products.search', ['s' => request('s')]);
        }

        return view('frontends.pages.home', compact('data', 'images'));
    }

    // Hàm đệ quy để lấy tất cả các danh mục con
    private function getAllChildrens($category)
    {
        $childrens = $category->childrens;

        foreach ($childrens as $child) {
            $child->childrens = $this->getAllChildrens($child); // Đệ quy lấy danh mục con của con
        }

        return $childrens;
    }

    // Hàm đệ quy để lấy tất cả sản phẩm
    private function getAllProducts($category)
    {
        // Lấy sản phẩm của danh mục hiện tại, giới hạn 15 sản phẩm
        $products = $category->products()->with('category')->limit(15)->get();

        // Lấy sản phẩm của tất cả các danh mục con
        foreach ($category->childrens as $child) {
            $childProducts = $this->getAllProducts($child);
            $products = $products->merge($childProducts);

            // Nếu đã đủ 15 sản phẩm thì dừng
            if ($products->count() >= 15) {
                return $products->take(15);
            }
        }

        return $products;
    }
}
