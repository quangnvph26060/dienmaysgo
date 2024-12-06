<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PromotionRequest;
use App\Models\SgoPromotion;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class PromotionController extends Controller
{
    public function index(Request $request)
    {

        $title = "Khuyễn mãi";
        if ($request->ajax()) {

            $data = SgoPromotion::select('id', 'name', 'slug', 'description', 'discount', 'start_date', 'end_date', 'status');
            return DataTables::of($data)
               ->addColumn('action', function ($row) {
                    return '<div style="display: flex;">
                                <a href="' . route('admin.promotion.edit', $row->id) . '" class="btn btn-primary btn-sm edit">
                                    <i class="fas fa-edit btn-edit" title="Sửa"></i>
                                </a>
                                <a href="#" class="btn btn-danger btn-sm delete"
                                    onclick="event.preventDefault(); document.getElementById(\'delete-form-' . $row->id . '\').submit();">
                                    <i class="fas fa-trash btn-delete" title="Xóa"></i>
                                </a>
                                <form id="delete-form-' . $row->id . '" action="' . route('admin.promotion.delete', $row->id) . '" method="POST" style="display:none;">
                                    ' . csrf_field() . '

                                </form>
                            </div>';
                })->rawColumns(['action'])
                ->make(true);
        }
        $page = 'Khuyễn mãi';
        return view('backend.promotion.index', compact('title', 'page'));
    }

    public function create()
    {
        $page = 'Khuyễn mãi';
        $title = 'Thêm Khuyễn mãi';
        return view('backend.promotion.form', compact( 'title', 'page'));
    }

    public function edit($id)
    {
        $page = 'Khuyễn mãi';
        $title = 'Sửa Khuyễn mãi';
        $promotion = SgoPromotion::find($id);
        return view('backend.promotion.form', compact('promotion', 'title', 'page'));
    }

    public function store(PromotionRequest $request)
    {
        try {
            // Tạo danh mục mới
            $promotion = SgoPromotion::create([
                'name' => $request->input('name'),
                'slug' => Str::slug($request->input('name')),
                'description' => $request->input('description'),
                'discount' => $request->input('discount'),
                'start_date' => $request->input('start_date'),
                'end_date' => $request->input('end_date'),
                'status' => $request->input('status'),
            ]);

            // Trả về thông báo thành công
            return redirect()->route('admin.promotion.index')->with('success', 'Khuyễn mãi đã được thêm thành công');
        } catch (\Exception $e) {
            // Nếu có lỗi, bắt và hiển thị thông báo lỗi
            return redirect()->route('admin.promotion.index')->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    public function update(PromotionRequest $request, $id)
    {
        try {

            $promotion = SgoPromotion::find($id);

            $promotion->update([
                'name' => $request->input('name'),
                'slug' => Str::slug($request->input('name')),
                'description' => $request->input('description'),
                'discount' => $request->input('discount'),
                'start_date' => $request->input('start_date'),
                'end_date' => $request->input('end_date'),
                'status' => $request->input('status'),

            ]);

            // Trả về thông báo thành công
            return redirect()->route('admin.promotion.index')->with('success', 'Khuyễn mãi đã được sửa thành công');
        } catch (\Exception $e) {
            // Nếu có lỗi, bắt và hiển thị thông báo lỗi
            return redirect()->back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    public function delete($id){
        try {
            $promotion = SgoPromotion::findOrFail($id);  // Tìm danh mục hoặc báo lỗi nếu không tìm thấy
            $promotion->delete();
            return redirect()->route('admin.promotion.index')->with('success', 'Xóa khuyến mãi thành công!');
        } catch (\Exception $e) {
            return redirect()->route('admin.promotion.index')->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }
}
