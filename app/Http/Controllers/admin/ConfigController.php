<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ConfigRequest;
use App\Models\SgoConfig;
use Illuminate\Http\Request;

class ConfigController extends Controller
{
    //

    public function index(){
        $config = SgoConfig::first();
        return view('backend.config.index', compact('config'));
    }

    public function update(ConfigRequest $request)
    {

        try {
            $credentials = $request->validated();
            $config = SgoConfig::first();
            $config->update($credentials);

            return redirect()->back()->with('success', 'Bài viết đã được sửa thành công');
        } catch (\Exception $e) {
            // Nếu có lỗi, bắt và hiển thị thông báo lỗi
            return redirect()->back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }
}
