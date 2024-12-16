<?php

namespace App\Http\Controllers\Frontends;

use App\Http\Controllers\Controller;
use App\Models\Introduces;
use App\Models\SgoConfig;
use App\Models\SgoHome;
use Illuminate\Http\Request;

class IntroduceController extends Controller
{
    public function introduce($slug = 'gioi-thieu')
    {
        $title = '11111111';
        if ($slug == 'gioi-thieu') {
            $title = 'Giới thiệu';
            $introduce = SgoConfig::first();
        } else {

            $introduce = SgoHome::where('slug', $slug)->first();
            if(!$introduce){
                abort(404);
            }
            $title = $introduce->name;
        }

        // Nếu không tìm thấy dữ liệu
        if (!$introduce) {
            abort(404);
        }
        // dd($title);
        return view('frontends.pages.introduce', compact('introduce','title'));
    }
}
