<?php

namespace App\Http\Controllers\Frontends;

use App\Http\Controllers\Controller;
use App\Models\SgoCategory;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home()
    {
        $catalogues = SgoCategory::query()->parent()->get();

        // dd($catalogues);

        return view('frontends.pages.home', compact('catalogues'));
    }
}
