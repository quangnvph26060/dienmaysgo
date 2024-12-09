<?php

namespace App\Http\Controllers\Frontends;

use App\Http\Controllers\Controller;
use App\Models\Introduces;
use Illuminate\Http\Request;

class IntroduceController extends Controller
{
    public function introduce()
    {
        $introduce = Introduces::first();
        return view('frontends.pages.introduce', compact('introduce'));
    }
}
