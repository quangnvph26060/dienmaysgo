<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ConfigRequest;
use App\Models\SgoConfig;
use Illuminate\Http\Request;

class ConfigController extends Controller
{
    //

    public function index()
    {
        $page = 'Cấu hình';
        $title = "Cấu hình";
        $config = SgoConfig::first();
        return view('backend.config.index', compact('config', 'page', 'title'));
    }

    public function update(ConfigRequest $request)
    {
        try {
            $credentials = $request->validated();

            // Lấy bản ghi đầu tiên, nếu không có thì tạo mới
            $config = SgoConfig::firstOrCreate([], $credentials);

            // Cập nhật nếu bản ghi đã tồn tại
            if (!$config->wasRecentlyCreated) {
                $config->update($credentials);
            }

            return redirect()->back()->with('success', 'Cấu hình đã được xử lý thành công');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }
}
