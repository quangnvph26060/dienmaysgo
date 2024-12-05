<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;     

class CategoryController extends Controller
{
    //
    public function index(){
        return view('backend.category.index');
    }

    public function create(){
        return view('backend.category.create');
    }
}
