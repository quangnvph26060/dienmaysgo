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
        $category = SgoCategory::where('slug', $slug)->with('products')->firstOrFail();

     
        $orderby = request('orderby');


        $productsQuery = $category->products();

        switch ($orderby) {
            case 'price-desc':
                $productsQuery = $productsQuery->orderBy('price', 'desc');
                break;

            case 'price':
                $productsQuery = $productsQuery->orderBy('price', 'asc');
                break;

            case 'date':
                $productsQuery = $productsQuery->orderBy('created_at', 'desc');
                break;

            case 'old-product':
                $productsQuery = $productsQuery->orderBy('created_at', 'asc');
                break;

            default:
                $productsQuery = $productsQuery->orderBy('created_at', 'desc');
                break;
        }

        // Phân trang
        $products = $productsQuery->paginate(10)->withQueryString();

        return view('frontends.pages.product.list', compact('category', 'products'));
    }


    public function detail($slug)
    {
        $product = SgoProduct::where('slug', $slug)->firstOrFail();
        $relatedProducts = SgoProduct::where('category_id', $product->category_id)->where('id', '!=', $product->id)->latest()->limit(8)->get();

        return view('frontends.pages.product.detail', compact('product', 'relatedProducts'));
    }
}
