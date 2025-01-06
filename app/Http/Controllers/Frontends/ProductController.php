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

    public function list($slug)
    {
        if (request()->ajax()) {
            return $this->filterProduct($slug);
        }

        Cache::flush();
        // Lấy thông tin danh mục và tất cả danh mục con
        $category = SgoCategory::where('slug', $slug)
            ->with('childrens') // Lấy cả quan hệ
            ->firstOrFail();

        $filters = Cache::remember("filters_$category->id", 3600, function () use ($category) { // Truyền $category vào callback
            return configFilter::query()
                ->with([
                    'attribute' => function ($query) use ($category) { // Truyền $category vào query
                        $query->with([
                            'attributeValues' => function ($subQuery) use ($category) { // Truyền $category vào subQuery
                                $subQuery->withCount(['products' => function ($q) use ($category) {
                                    $q->where('category_id', $category->id);
                                }]);
                            }
                        ]);
                    }
                ])->latest()->get();
        });

        $attributes = $filters->where('filter_type', 'attribute');

        // Cache brands
        $brands = Cache::remember("brands_$category->id", 3600, function () use ($filters, $category) {
            if ($filters->contains('filter_type', 'brand')) {
                return [
                    'title' => $filters->where('filter_type', 'brand')->first()->title,
                    'data' => Brand::query()
                        ->withCount(['products' => function ($q) use ($category) {
                            $q->where('category_id', $category->id);
                        }])
                        ->latest()
                        ->get()->toArray(),
                ];
            }
            return [];
        });

        // Lấy toàn bộ ID danh mục cha và con
        $categoryIds = collect([$category->id])->merge($category->allChildrenIds());

        // Query sản phẩm thuộc danh mục cha và con
        $productsQuery = SgoProduct::query()
            ->with(['promotion'])
            ->whereIn('category_id', $categoryIds);

        $products = $productsQuery->paginate(16)->withQueryString();

        return view('frontends.pages.product.list', compact('category', 'products', 'brands', 'attributes'));
    }

    public function filterProduct($slug)
    {
        // Cache::flush();
        // Lấy dữ liệu request
        $attributes = request()->input('attr', []);
        $brands = request()->input('brand', []);
        $orderby = request('orderby', 'date');

        // Tạo cache key duy nhất
        $cacheKey = "products_filter_{$slug}_" . md5(json_encode([
            'attributes' => $attributes,
            'brands' => $brands,
            'orderby' => $orderby,
            'page' => request('page', 1), // Thêm số trang nếu có phân trang
        ]));

        // Kiểm tra cache
        return Cache::remember($cacheKey, now()->addMinutes(30), function () use ($slug, $attributes, $brands, $orderby) {
            // Lấy thông tin danh mục và tất cả danh mục con
            $category = SgoCategory::where('slug', $slug)
                ->with('childrens:id,category_parent_id')
                ->firstOrFail();

            $categoryIds = collect([$category->id])->merge($category->allChildrenIds());

            // Tạo query cơ bản
            $productsQuery = SgoProduct::query()
                ->select(['sgo_products.id', 'sgo_products.name', 'price', 'image', 'promotions_id', 'sgo_products.slug'])
                ->whereIn('category_id', $categoryIds);

            // Lọc theo attributes nếu có
            if (!empty($attributes)) {
                $productsQuery->where('category_id', $category->id)->whereExists(function ($query) use ($attributes) {
                    $query->select(DB::raw(1))
                        ->from('product_attribute_values')
                        ->whereColumn('product_attribute_values.sgo_product_id', 'sgo_products.id')
                        ->whereIn('product_attribute_values.attribute_value_id', $attributes);
                });
            }

            // Lọc theo brands nếu có
            if (!empty($brands)) {
                $productsQuery->where('category_id', $category->id)->whereExists(function ($query) use ($brands) {
                    $query->select(DB::raw(1))
                        ->from('brand_product')
                        ->whereColumn('brand_product.product_id', 'sgo_products.id')
                        ->whereIn('brand_product.brand_id', $brands);
                });
            }

            $productsQuery->selectRaw('sgo_products.*, sgo_promotions.discount,
            CASE
                WHEN promotions_id IS NOT NULL THEN price * (1 - sgo_promotions.discount / 100)
                ELSE price
            END as final_price')
                ->leftJoin('sgo_promotions', 'sgo_products.promotions_id', '=', 'sgo_promotions.id');

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
