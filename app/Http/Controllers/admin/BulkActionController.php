<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BulkActionController extends Controller
{
    public function deleteItems(Request $request)
    {
        $validatedData = $request->validate([
            'model' => 'required|string',
            'ids' => 'required|array',
        ]);

        $modelClass = 'App\\Models\\' . $validatedData['model'];

        // Kiểm tra xem class có tồn tại hay không
        if (!class_exists($modelClass)) {
            return response()->json(['message' => 'Model không hợp lệ.'], 400);
        }

        try {
            // Thực hiện xóa các bản ghi dựa trên ID
            $modelClass::whereIn('id', $validatedData['ids'])->delete();

            return response()->json(['message' => 'Xóa thành công!'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Có lỗi xảy ra: ' . $e->getMessage()], 500);
        }
    }
}
