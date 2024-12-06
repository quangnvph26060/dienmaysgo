<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\OriginRequest;
use App\Models\SgoOrigin;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class OriginController extends Controller
{
    public function index(Request $request)
    {

        $title = "Xuất xứ";
        if ($request->ajax()) {

            $data = SgoOrigin::select('id', 'name', 'slug', 'description');
            return DataTables::of($data)
            ->addColumn('description', function ($row) {
                // Trả về nội dung HTML từ cột content
                return $row->description;
            })
               ->addColumn('action', function ($row) {
                    return '<div style="display: flex;">
                                <a href="' . route('admin.origin.edit', $row->id) . '" class="btn btn-primary btn-sm edit">
                                    <i class="fas fa-edit btn-edit" title="Sửa"></i>
                                </a>
                                <a href="#" class="btn btn-danger btn-sm delete"
                                    onclick="event.preventDefault(); document.getElementById(\'delete-form-' . $row->id . '\').submit();">
                                    <i class="fas fa-trash btn-delete" title="Xóa"></i>
                                </a>
                                <form id="delete-form-' . $row->id . '" action="' . route('admin.origin.delete', $row->id) . '" method="POST" style="display:none;">
                                    ' . csrf_field() . '

                                </form>
                            </div>';
                })->rawColumns(['action', 'description'])
                ->make(true);
        }
        $page = 'Xuất xứ';
        return view('backend.origin.index', compact('title', 'page'));
    }

    public function create()
    {
        $page = 'Xuất xứ';
        $title = 'Thêm xuất xứ';
        return view('backend.origin.form', compact( 'title', 'page'));
    }

    public function edit($id)
    {
        $page = 'Xuất xứ';
        $title = 'Sửa xuất xứ';
        $origin = SgoOrigin::find($id);
        return view('backend.origin.form', compact('origin', 'title', 'page'));
    }

    public function store(OriginRequest $request)
    {
        try {
            // Tạo danh mục mới
            $origin = SgoOrigin::create([
                'name' => $request->input('name'),
                'slug' => Str::slug($request->input('name')),
                'description' => $request->input('description'),

            ]);

            // Trả về thông báo thành công
            return redirect()->route('admin.origin.index')->with('success', 'Xuất xứ đã được thêm thành công');
        } catch (\Exception $e) {
            // Nếu có lỗi, bắt và hiển thị thông báo lỗi
            return redirect()->route('admin.origin.index')->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    public function update(OriginRequest $request, $id)
    {
        try {

            $origin = SgoOrigin::find($id);

            $origin->update([
                'name' => $request->input('name'),
                'slug' => Str::slug($request->input('name')),
                'description' => $request->input('description'),

            ]);

            // Trả về thông báo thành công
            return redirect()->route('admin.origin.index')->with('success', 'Xuất xứ đã được sửa thành công');
        } catch (\Exception $e) {
            // Nếu có lỗi, bắt và hiển thị thông báo lỗi
            return redirect()->back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    public function delete($id){
        try {
            $origin = SgoOrigin::findOrFail($id);  // Tìm danh mục hoặc báo lỗi nếu không tìm thấy
            $origin->delete();
            return redirect()->route('admin.origin.index')->with('success', 'Xóa xuất xứ thành công!');
        } catch (\Exception $e) {
            return redirect()->route('admin.origin.index')->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }
}
