<?php

namespace App\Http\Controllers\Frontends;

use App\Models\Brand;
use App\Models\configFilter;
use App\Models\SgoProduct;
use App\Models\SgoCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{

    public function list($slug = null)
    {
        // Cache::flush();
        if (request()->ajax()) {
            return $this->filterProduct($slug);
        }

        // Nếu không có slug, xử lý logic hiển thị toàn bộ sản phẩm
        $category = null;
        if ($slug) {
            // Lấy thông tin danh mục và tất cả danh mục con
            $category = SgoCategory::where('slug', $slug)
                ->with('childrens') // Lấy cả quan hệ
                ->firstOrFail();
        }

        // Lấy bộ lọc từ cache hoặc tạo mới
        $filters = Cache::remember("filters_" . ($category ? $category->id : 'all'), now()->addMinutes(5), function () use ($category) {
            $search = request('s'); // Lấy từ khóa tìm kiếm nếu có

            return configFilter::query()
                ->with([
                    'attribute' => function ($query) use ($category, $search) {
                        $query->with([
                            'attributeValues' => function ($subQuery) use ($category, $search) {
                                $subQuery->withCount(['products' => function ($q) use ($category, $search) {
                                    if ($category) {
                                        $q->where('category_id', $category->id);
                                    }
                                    if (!empty($search)) {
                                        $q->where('name', 'like', '%' . $search . '%');
                                    }
                                }]);
                            }
                        ]);
                    }
                ])->latest()->get();
        });

        $attributes = $filters->where('filter_type', 'attribute');

        $brands = Cache::remember("brands_" . ($category ? $category->id : 'all'), now()->addMinutes(5), function () use ($filters, $category) {
            if ($filters->contains('filter_type', 'brand')) {
                $search = request('s'); // Lấy từ khóa tìm kiếm nếu có

                return [
                    'title' => $filters->where('filter_type', 'brand')->first()->title,
                    'data' => Brand::query()
                        ->withCount(['products' => function ($q) use ($category, $search) {
                            if ($category) {
                                $q->where('category_id', $category->id);
                            }
                            if (!empty($search)) {
                                $q->where('name', 'like', '%' . $search . '%');
                            }
                        }])
                        ->latest()
                        ->get()
                        ->toArray(),
                ];
            }
            return [];
        });

        $categoryIds = $category ? collect([$category->id])->merge($category->allChildrenIds()) : [];

        // Query sản phẩm
        $productsQuery = SgoProduct::query()
            ->with(['promotion']);

        if (!empty(request('s'))) {
            $productsQuery->where('name', 'like', '%' . request('s') . '%');
        }

        if (!empty($categoryIds)) {
            $productsQuery->whereIn('category_id', $categoryIds);
        }

        $products = $productsQuery->paginate(16);

        $products->appends(request()->query());

        return view('frontends.pages.product.list', compact('category', 'products', 'brands', 'attributes'));
    }


    public function filterProduct($slug = null)
    {
        // Lấy dữ liệu request
        $attributes = request()->input('attr', []);
        $brands = request()->input('brand', []);
        $orderby = request('orderby', 'date');
        $search = request('s', ''); // Lấy từ khóa tìm kiếm nếu có

        // Tạo cache key duy nhất
        $cacheKey = "products_filter_" . ($slug ?? 'all') . "_" . md5(json_encode([
            'attributes' => $attributes,
            'brands' => $brands,
            'orderby' => $orderby,
            'search' => $search, // Thêm từ khóa tìm kiếm vào cache key
            'page' => request('page', 1),
        ]));

        // Kiểm tra cache
        return Cache::remember($cacheKey, now()->addMinutes(30), function () use ($slug, $attributes, $brands, $orderby, $search) {
            // Lấy thông tin danh mục và tất cả danh mục con
            $category = $slug ? SgoCategory::where('slug', $slug)
                ->with('childrens:id,category_parent_id')
                ->firstOrFail() : null;

            $categoryIds = $category ? collect([$category->id])->merge($category->allChildrenIds()) : [];

            // Tạo query cơ bản
            $productsQuery = SgoProduct::query()
                ->select(['sgo_products.id', 'sgo_products.name', 'price', 'image', 'promotions_id', 'sgo_products.slug']);

            // Lọc theo từ khóa tìm kiếm
            if (!empty($search)) {
                $productsQuery->where('sgo_products.name', 'like', '%' . $search . '%');
            }

            if (!empty($categoryIds)) {
                $productsQuery->whereIn('category_id', $categoryIds);
            }

            // Lọc theo attributes nếu có
            if (!empty($attributes)) {
                $productsQuery->where(function ($query) use ($attributes, $category) {
                    $query->whereExists(function ($subQuery) use ($attributes) {
                        $subQuery->select(DB::raw(1))
                            ->from('product_attribute_values')
                            ->whereColumn('product_attribute_values.sgo_product_id', 'sgo_products.id')
                            ->whereIn('product_attribute_values.attribute_value_id', $attributes);
                    });

                    if ($category) {
                        $query->where('category_id', $category->id);
                    }
                });
            }

            // Lọc theo brands nếu có
            if (!empty($brands)) {
                $productsQuery->where(function ($query) use ($brands, $category) {
                    $query->whereExists(function ($subQuery) use ($brands) {
                        $subQuery->select(DB::raw(1))
                            ->from('brand_product')
                            ->whereColumn('brand_product.product_id', 'sgo_products.id')
                            ->whereIn('brand_product.brand_id', $brands);
                    });

                    if ($category) {
                        $query->where('category_id', $category->id);
                    }
                });
            }

            // Thêm trường giá cuối cùng (final_price)
            $productsQuery->selectRaw('sgo_products.*, sgo_promotions.discount,
        CASE
            WHEN promotions_id IS NOT NULL THEN price * (1 - sgo_promotions.discount / 100)
            ELSE price
        END as final_price')
                ->leftJoin('sgo_promotions', 'sgo_products.promotions_id', '=', 'sgo_promotions.id');

            // Sắp xếp theo orderby
            switch ($orderby) {
                case 'price-desc':
                    $productsQuery->orderBy('final_price', 'desc');
                    break;
                case 'price':
                    $productsQuery->orderBy('final_price', 'asc');
                    break;
                case 'date':
                    $productsQuery->orderBy('created_at', 'desc');
                    break;
                case 'old-product':
                    $productsQuery->orderBy('created_at', 'asc');
                    break;
            }

            // Lấy danh sách sản phẩm sau khi lọc
            $products = $productsQuery->paginate(16)->withQueryString();

            return [
                'html' => view('components.products', compact('products'))->render(),
                'pagination' => (string) $products->links(),
            ];
        });
    }



    public function detail($slug)
    {
        // Lấy sản phẩm chi tiết
        $product = SgoProduct::with('images', 'brands', 'category.parent', 'category.childrens')
            ->where('slug', $slug)
            ->firstOrFail();

        // Lấy danh mục cha, anh em, và con
        $category = $product->category;
        $categoryIds = collect([$category->id]); // ID của danh mục hiện tại

        // Thêm danh mục cha (nếu có)
        if ($category->category_parent_id) {
            $categoryIds->push($category->category_parent_id);
        }

        // Thêm danh mục anh em (cùng cấp)
        if ($category->parent) {
            $categoryIds = $categoryIds->merge($category->parent->childrens->pluck('id'));
        }

        // Thêm danh mục con
        $categoryIds = $categoryIds->merge($category->childrens->pluck('id'))->unique();

        // Query sản phẩm liên quan
        $relatedProducts = SgoProduct::whereIn('category_id', $categoryIds)
            ->where('id', '!=', $product->id) // Loại trừ sản phẩm hiện tại
            ->latest()
            ->limit(8)
            ->get();

        return view('frontends.pages.product.detail', compact('product', 'relatedProducts'));
    }
}
