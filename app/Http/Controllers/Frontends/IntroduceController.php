<?php

namespace App\Http\Controllers\Frontends;

use App\Http\Controllers\Controller;
use App\Models\Introduces;
use App\Models\SgoConfig;
use Illuminate\Http\Request;

class IntroduceController extends Controller
{
    public function introduce()
    {
        $introduce = SgoConfig::first();
        return view('frontends.pages.introduce', compact('introduce'));
    }
}
