<?php

namespace App\Http\Controllers\Frontends;

use App\Models\SgoProduct;
use App\Models\SgoCategory;
use App\Models\Slider;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function home()
    {
        // Lấy tất cả danh mục cha
        $categories = SgoCategory::whereNull('category_parent_id')->get();

        // Hàm đệ quy để lấy tất cả các sản phẩm từ danh mục cha và con
        $data = $categories->map(function ($category) {
            return [
                'parent' => $category, // Danh mục cha
                'childrens' => $this->getAllChildrens($category), // Lấy tất cả danh mục con
                'products' => $this->getAllProducts($category), // Lấy tất cả sản phẩm của danh mục cha và các danh mục con
            ];
        });

        $images = Slider::query()->latest()->pluck('url', 'id')->toArray();

        // Xử lý tìm kiếm và sắp xếp sản phẩm
        $query = SgoProduct::query();

        if (request('s')) {
            $query->where('name', 'like', '%' . request('s') . '%');

            if (request('orderby')) {
                $orderby = request('orderby');
                switch ($orderby) {
                    case 'price':
                        $query->orderBy('price', 'asc');
                        break;
                    case 'price-desc':
                        $query->orderBy('price', 'desc');
                        break;
                    case 'date':
                        $query->orderBy('created_at', 'desc');
                        break;
                    case 'old-product':
                        $query->orderBy('created_at', 'asc');
                        break;
                    default:
                        $query->orderBy('name', 'asc');
                        break;
                }
            }

            $products = $query->paginate(12);

            return view('frontends.pages.product.list', compact('products'));
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
        // Lấy sản phẩm của danh mục hiện tại
        $products = $category->products;

        // Lấy sản phẩm của tất cả các danh mục con
        foreach ($category->childrens as $child) {
            $products = $products->merge($this->getAllProducts($child)); // Đệ quy lấy sản phẩm của các danh mục con
        }

        return $products;
    }
}
