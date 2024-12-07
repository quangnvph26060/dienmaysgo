<?php

namespace App\Http\Controllers\Frontends;

use App\Models\SgoProduct;
use App\Models\SgoCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function home()
    {
        $catalogues = SgoCategory::query()->parent()->get();

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

            return view('frontends.pages.product.list', compact('products', 'catalogues'));
        }

        return view('frontends.pages.home', compact('catalogues'));
    }
}
