<?php

namespace App\Http\Controllers\Frontends;

use App\Http\Controllers\Controller;
use App\Models\SgoNews;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function list($slug = null)
    {
        $latestNews = SgoNews::latest()->take(8)->get();
        if ($slug) {
            $news = SgoNews::where('slug', $slug)->firstOrFail();
            return view('frontends.pages.news.detail', compact('news', 'latestNews'));
        } else {
            $news = SgoNews::paginate(10);
            return view('frontends.pages.news.list', compact('news', 'latestNews'));
        }
    }
}
