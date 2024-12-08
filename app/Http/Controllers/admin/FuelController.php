<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\SgoFuel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class FuelController extends Controller
{
    public function index(Request $request)
    {
        $title = "Nhiên liệu";
        if ($request->ajax()) {
            $data = SgoFuel::select('id', 'name', 'slug', 'description');

            return DataTables::of($data)
                ->addColumn('description', function ($row) {
                    return $row->description; // Trả về nội dung mô tả
                })
                ->addColumn('action', function ($row) {
                    $editUrl = route('admin.fuel.edit', $row->id);
                    $deleteUrl = route('admin.fuel.delete', $row->id);

                    // Nút Sửa và Xóa
                    $actions = '<div style="display: flex; gap: 10px;">
                                <a href="' . $editUrl . '" class="btn btn-warning btn-sm edit">
                                    <i class="fas fa-edit" title="Sửa"></i> Sửa
                                </a>
                                <button type="button" class="btn btn-danger btn-sm delete"
                                    onclick="confirmDelete(' . $row->id . ')">
                                    <i class="fas fa-trash" title="Xóa"></i> Xóa
                                </button>
                                <form id="delete-form-' . $row->id . '" action="' . $deleteUrl . '" method="POST" style="display: none;">
                                    ' . csrf_field() . '
                                    ' . method_field('DELETE') . '
                                </form>
                            </div>';
                    return $actions;
                })
                ->rawColumns(['action', 'description']) // Đảm bảo HTML không bị escape
                ->make(true);
        }

        $page = 'Nhiên liệu';
        return view('backend.fuel.index', compact('title', 'page'));
    }

    public function edit($id)
    {
        $fuel = SgoFuel::findOrFail($id);
        return response()->json($fuel);
    }
    public function store(Request $request)
    {
        // Validate dữ liệu
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        // Tạo mới bản ghi Fuel
        $fuel = new SgoFuel();
        $fuel->name = $validated['name'];
        $fuel->slug = Str::slug($validated['name']);
        $fuel->description = $validated['description'];
        $fuel->save();

        // Trả về phản hồi JSON
        return response()->json([
            'success' => true,
            'message' => 'Thêm nhiên liệu thành công!',
            'data' => $fuel
        ]);
    }
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:sgo_fuel,name,' . $id,
            'description' => 'required|string',
        ]);

        // Tìm Fuel cần sửa
        $fuel = SgoFuel::findOrFail($id);
        $fuel->name = $validated['name'];
        $fuel->slug = Str::slug($validated['name']);
        $fuel->description = $validated['description'];
        $fuel->save();

        // Trả về phản hồi JSON
        return response()->json([
            'success' => true,
            'message' => 'Cập nhật nhiên liệu thành công!',
            'data' => $fuel
        ]);
    }

    public function delete($id)
    {
        Log::info($id);
        $fuel = SgoFuel::findOrFail($id);

        $fuel->delete();
        return response()->json([
            'success' => true,
            'message' => 'Nhiên liệu đã được xóa thành công!'
        ]);
    }
}
