<?php

namespace App\Http\Controllers\Frontends;

use App\Models\ProductAttributeValue;
use App\Models\SgoProduct;
use App\Models\SgoCategory;
use App\Models\Slider;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\HistorySearch;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;


class HomeController extends Controller
{

    // private function isImageValid($path)
    // {
    //     return @getimagesize($path) !== false; // Sử dụng @ để ngăn lỗi hiển thị
    // }
    public function home()
    {

        // $brands = Brand::pluck('id', 'name')->mapWithKeys(function ($id, $name) {
        //     return [Str::lower($name) => $id]; // Chuyển thương hiệu về chữ thường
        // })->toArray(); // Chuyển sang mảng

        // // Danh sách các từ khóa thương hiệu (dạng chữ thường)
        // $brandNames = array_keys($brands);

        // SgoProduct::chunk(500, function ($products) use ($brands, $brandNames) {
        //     foreach ($products as $product) {
        //         $productName = Str::lower($product->name);

        //         // Kiểm tra xem sản phẩm có chứa thương hiệu nào không
        //         if (!Str::contains($productName, $brandNames)) {
        //             continue; // Nếu không có thương hiệu nào, bỏ qua sản phẩm này
        //         }

        //         // Kiểm tra và cập nhật thương hiệu phù hợp
        //         foreach ($brands as $brandName => $brandId) {
        //             if (Str::contains($productName, $brandName)) {
        //                 if ($product->brand_id !== $brandId) {
        //                     $oldBrand = $product->brand_id ? "({$product->brand_id})" : '(null)';
        //                     $product->update(['brand_id' => $brandId]);
        //                     logInfo("Cập nhật: {$product->name} từ $oldBrand -> ($brandId)");
        //                 }
        //                 break; // Dừng sau khi tìm thấy thương hiệu phù hợp
        //             }
        //         }
        //     }
        // });

        // logInfo("Hoàn thành cập nhật thương hiệu cho sản phẩm!");

        // Cache::flush();
        // $directory = public_path('storage/products');
        // $corruptedImages = []; // Mảng để lưu danh sách ảnh bị hỏng

        // // Bước 1: Lấy danh sách ảnh bị hỏng
        // if (File::exists($directory)) {
        //     $files = File::files($directory);
        //     foreach ($files as $file) {
        //         if (in_array($file->getExtension(), ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
        //             if (!$this->isImageValid($file->getRealPath())) {
        //                 logInfo($file->getFilename());
        //                 $corruptedImages[] = $file->getFilename();
        //             }
        //         }
        //     }
        // }

        // // Bước 2: Xóa sản phẩm có ảnh bị lỗi
        // foreach ($corruptedImages as $image) {
        //     // Lấy tên sản phẩm tương ứng từ tên file ảnh
        //     $product = SgoProduct::where('image', 'products/' . $image)->first();

        //     if ($product) {
        //         // Xóa sản phẩm
        //         $product->delete();
        //         deleteImage('products/' . $image);
        //     }
        // }

        // dd($corruptedImages);

        // $productsWithoutAttributes = SgoProduct::whereNotIn('id', function ($query) {
        //     $query->select('sgo_product_id')->from('product_attribute_values');
        // })->get();

        // $defaultAttributes = [
        //     ['attribute_id' => 26, 'attribute_value_id' => 44], // Nguồn điện 220V
        //     ['attribute_id' => 23, 'attribute_value_id' => 45], // Bảo hành 6 tháng
        //     ['attribute_id' => 21, 'attribute_value_id' => 28], // Xuất xứ Trung Quốc
        // ];

        // // Duyệt qua danh sách sản phẩm chưa có thuộc tính và thêm thuộc tính mặc định
        // foreach ($productsWithoutAttributes as $product) {
        //     foreach ($defaultAttributes as $default) {
        //         ProductAttributeValue::create([
        //             'sgo_product_id' => $product->id,
        //             'attribute_id' => $default['attribute_id'],
        //             'attribute_value_id' => $default['attribute_value_id']
        //         ]);
        //     }
        // }

        // $categories = SgoCategory::all()->keyBy('id'); // Chuyển đổi thành mảng với key là id
        // $products = SgoProduct::whereNull('category_id')->get(); // Lấy ra sản phẩm chưa có danh mục

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

        // return 'Danh mục đã được gán cho các sản phẩm.';

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
        $products = $category->products()->with('category')->limit(10)->get();

        // Lấy sản phẩm của tất cả các danh mục con
        foreach ($category->childrens as $child) {
            $childProducts = $this->getAllProducts($child);
            $products = $products->merge($childProducts);

            // Nếu đã đủ 15 sản phẩm thì dừng
            if ($products->count() >= 10) {
                return $products->take(10);
            }
        }

        return $products;
    }
}
