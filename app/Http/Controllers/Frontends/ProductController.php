<?php

namespace App\Http\Controllers\Frontends;

use App\Models\SgoProduct;
use App\Models\SgoCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{

    public function list($slug)
    {
        $category = SgoCategory::where('slug', $slug)->firstOrFail();

        $productsQuery = SgoProduct::with(['fuel', 'promotion'])
            ->where('category_id', $category->id);

        // Lọc theo loại nhiên liệu
        $fuel = request('filter_nhien-lieu');
        if ($fuel) {
            $productsQuery->whereHas('fuel', function ($query) use ($fuel) {
                $query->where('name', $fuel);
            });
        }

        // Lọc theo giá
        $orderby = request('orderby');

        $products = SgoProduct::with('fuel')
            ->where('category_id', $category->id)
            ->get();

        // Lấy danh sách nhiên liệu
        $fuels = $products->pluck('fuel.name')->unique()->mapWithKeys(function ($item) use ($products) {
            return [$item => $products->where('fuel.name', $item)->count()];
        });

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

            default:
                $productsQuery->orderBy('created_at', 'desc');
                break;
        }

        // Phân trang
        $products = $productsQuery->paginate(10)->withQueryString();


        return view('frontends.pages.product.list', compact('category', 'products', 'fuels'));
    }


    public function detail($slug)
    {
        $product = SgoProduct::with('images')->where('slug', $slug)->firstOrFail();

        $relatedProducts = SgoProduct::where('category_id', $product->category_id)->where('id', '!=', $product->id)->latest()->limit(8)->get();

        return view('frontends.pages.product.detail', compact('product', 'relatedProducts'));
    }
}
