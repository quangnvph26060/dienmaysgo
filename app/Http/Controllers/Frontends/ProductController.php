<?php

namespace App\Http\Controllers\Frontends;

use App\Models\Brand;
use App\Models\configFilter;
use App\Models\ProductView;
use App\Models\SgoProduct;
use App\Models\SgoCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;
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
        $filters = Cache::remember("filters_" . request('s', '') . ($category ? $category->id : 'all'), now()->addMinutes(5), function () use ($category) {
            $search = request('s');

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

        $attributes = $filters->where('filter_type', 'attribute')->sortBy('location')->map(function ($attribute) {
            $filteredValues = $attribute->attribute->attributeValues->filter(function ($value) {
                return $value->products_count > 0; // Chỉ giữ giá trị có sản phẩm
            });

            if ($filteredValues->isNotEmpty()) {
                $attribute->attribute->attributeValues = $filteredValues;
                return $attribute;
            }

            return null;
        })->filter();



        $priceFilter = $filters->where('filter_type', 'price')->first();
        $priceOptions = [];

        if (!empty($priceFilter) && !empty($priceFilter->option_price)) {
            $priceRanges = explode(',', $priceFilter->option_price);

            foreach ($priceRanges as $range) {
                $prices = explode('-', trim($range));
                $formattedRange = implode(' - ', array_map(function ($price) {
                    return $this->formatPrice($price); // Định dạng giá ở đây
                }, $prices));

                $priceOptions[] = $formattedRange; // Lưu giá đã format vào mảng
            }
        }

        $brands = Cache::remember("brands_" . ($category ? $category->id : 'all'), now()->addMinutes(5), function () use ($filters, $category) {
            if ($filters->contains('filter_type', 'brand')) {
                $search = request('s'); // Lấy từ khóa tìm kiếm nếu có

                $filteredBrands = Brand::query()
                    ->withCount(['products' => function ($q) use ($category, $search) {
                        if ($category) {
                            $q->where('category_id', $category->id);
                        }
                        if (!empty($search)) {
                            $q->where('name', 'like', '%' . $search . '%');
                        }
                    }])
                    ->having('products_count', '>', 0)
                    ->latest()
                    ->get()
                    ->toArray();

                return empty($filteredBrands) ? [] : [
                    'title' => $filters->where('filter_type', 'brand')->first()->title,
                    'data' => $filteredBrands
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

        return view('frontends.pages.product.list', compact('category', 'products', 'brands', 'attributes', 'priceOptions', 'priceFilter'));
    }
    private function formatPrice($price)
    {
        $price = (int) $price;

        $price *= 1000;

        return number_format($price, 0, ',', '.'); // Định dạng số thành 10.000 hoặc 10.000.000
    }


    public function filterProduct($slug = null)
    {
        // Lấy dữ liệu request
        $attributes = request()->input('attr', []);
        $brands = request()->input('brand', []);
        $orderby = request('orderby', 'date');
        $search = request('s', ''); // Lấy từ khóa tìm kiếm nếu có
        $priceRange = request('price_range'); // Lấy khoảng giá đã chọn từ request

        // Tạo cache key duy nhất
        $cacheKey = "products_filter_" . ($slug ?? 'all') . "_" . md5(json_encode([
            'attributes' => $attributes,
            'brands' => $brands,
            'orderby' => $orderby,
            'search' => $search, // Thêm từ khóa tìm kiếm vào cache key
            'price_range' => $priceRange, // Thêm khoảng giá vào cache key
            'page' => request('page', 1),
        ]));

        // Kiểm tra cache
        return Cache::remember($cacheKey, now()->addMinutes(30), function () use ($slug, $attributes, $brands, $orderby, $search, $priceRange) {
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

            // Lọc theo khoảng giá nếu có
            // Lọc theo khoảng giá nếu có
            if (!empty($priceRange)) {
                // Tách khoảng giá thành min và max
                $priceParts = explode(' - ', $priceRange);
                if (count($priceParts) == 2) {
                    $minPrice = str_replace('.', '', $priceParts[0]); // Loại bỏ dấu chấm và convert về số
                    $maxPrice = str_replace('.', '', $priceParts[1]); // Loại bỏ dấu chấm và convert về số

                    // Sử dụng giá giảm từ sản phẩm nếu có
                    $productsQuery->where(function ($query) use ($minPrice, $maxPrice) {
                        $query->whereBetween(DB::raw('CASE
                    WHEN discount_value IS NOT NULL
                        AND discount_end_date >= NOW() THEN
                        CASE
                            WHEN discount_type = "percentage" THEN price * (1 - discount_value / 100)
                            WHEN discount_type = "amount" THEN price - discount_value
                            ELSE price
                        END
                    WHEN promotions_id IS NOT NULL
                        AND sgo_promotions.end_date >= NOW() THEN price * (1 - sgo_promotions.discount / 100)
                    ELSE price
                END'), [(int)$minPrice, (int)$maxPrice]);
                    });
                }
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




    public function detail($catalogue = null, $slug = null)
    {

        if (!$slug) return $this->list($catalogue);
        // Lấy sản phẩm chi tiết
        $product = SgoProduct::with('images', 'brand', 'category.parent', 'category.childrens', 'attributes:id,name', 'attributeValues:id,value')
            ->where('slug', $slug)
            ->firstOrFail();

        if ($catalogue) {
            if (is_null($product->category)) abort(404);
        }

        $this->incrementView($product);

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

    private function incrementView($product)
    {
        $ip = request()->ip();
        $userAgent = request()->header('User-Agent');
        $cacheKey = "viewed_product_{$product->id}_{$ip}";

        // Lấy bản ghi xem trước đó từ DB
        $view = ProductView::where('product_id', $product->id)
            ->where('ip_address', $ip)
            ->latest() // Lấy bản ghi mới nhất
            ->first();

        // Kiểm tra nếu cache không tồn tại (mới vào trang hoặc đã quá 10 phút)
        if (!Cache::has($cacheKey)) {
            Cache::put($cacheKey, true, now()->addMinutes(5)); // Set timeout 5 phút để tránh spam

            if ($view) {
                // Kiểm tra nếu lần truy cập trước đó đã quá 10 phút
                $timeDifference = now()->diffInMinutes($view->start_time);

                if ($timeDifference >= 5) {
                    // Nếu quá 5 phút, tạo bản ghi mới và tăng lượt xem
                    ProductView::create([
                        'product_id' => $product->id,
                        'ip_address' => $ip,
                        'user_agent' => $userAgent,
                        'start_time' => now(),
                    ]);

                    // Cập nhật số lượt xem trong bảng products
                    $product->increment('view_count');
                } else {
                    // Nếu chưa đủ 10 phút, chỉ cập nhật lại `start_time` và `end_time`
                    $view->update([
                        'start_time' => now(),
                        'end_time' => null, // Nếu người dùng đã thoát ra, reset end_time
                    ]);
                }
            } else {
                // Nếu lần đầu tiên truy cập, tạo mới bản ghi
                ProductView::create([
                    'product_id' => $product->id,
                    'ip_address' => $ip,
                    'user_agent' => $userAgent,
                    'start_time' => now(),
                ]);

                // Cập nhật số lượt xem trong bảng products
                $product->increment('view_count');
            }
        }
    }



    public function endView(Request $request)
    {
        $data = json_decode($request->getContent(), true);

        $productId = $data['product_id'];

        $ip = request()->ip();

        $view = ProductView::where('product_id', $productId)
            ->where('ip_address', $ip)
            ->latest()
            ->first();

        if ($view) {

            $view->update([
                'end_time' => now()
            ]);
        }
    }


    public function listCategory()
    {
        return view('frontends.pages.category');
    }
}
