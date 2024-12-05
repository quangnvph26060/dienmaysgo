<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\SgoCategory;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class CategoryController extends Controller
{
    //
    public function index(Request $request)
    {
        $title = "Danh mục";
        if ($request->ajax()) {

            $data = SgoCategory::with('parent')
                ->select('id', 'name', 'slug', 'description', 'logo', 'category_parent_id', 'title_seo', 'description_seo', 'keyword_seo');
            return DataTables::of($data)
                ->addColumn('parent_name', function ($row) {

                    return $row->parent ? $row->parent->name : '--------';
                })
                ->addColumn('action', function ($row) {
                    return '<div style="display: flex;">
                                <a href="' . route('admin.category.edit', $row->id) . '" class="btn btn-primary btn-sm edit">
                                    <i class="fas fa-edit btn-edit" title="Sửa"></i>
                                </a>
                                <a href="#" class="btn btn-danger btn-sm delete"
                                    onclick="event.preventDefault(); document.getElementById(\'delete-form-' . $row->id . '\').submit();">
                                    <i class="fas fa-trash btn-delete" title="Xóa"></i>
                                </a>
                                <form id="delete-form-' . $row->id . '" action="' . route('admin.category.delete', $row->id) . '" method="POST" style="display:none;">
                                    ' . csrf_field() . '

                                </form>
                            </div>';
                })->rawColumns(['action'])
                ->make(true);
        }
        $page = 'Danh mục';
        return view('backend.category.index', compact('title', 'page'));
    }

    public function create()
    {
        $page = 'Danh mục';
        $title = 'Thêm danh mục';
        $parentCategories = SgoCategory::whereNull('category_parent_id')->get();
        return view('backend.category.create', compact('parentCategories', 'title', 'page'));
    }

    public function edit($id)
    {
        $page = 'Danh mục';
        $title = 'Sửa danh mục';
        $category = SgoCategory::find($id);
        $parentCategories = SgoCategory::whereNull('category_parent_id')->get();
        return view('backend.category.create', compact('category', 'parentCategories', 'title', 'page'));
    }

    public function store(CategoryRequest $request)
    {
        dd($request->all());
    }

    public function update(CategoryRequest $request)
    {
        dd($request->all());
    }

    public function delete($id){
        try {
            $category = SgoCategory::findOrFail($id);  // Tìm danh mục hoặc báo lỗi nếu không tìm thấy
            $category->delete();
            return redirect()->route('admin.category.index')->with('success', 'Xóa danh mục thành công!');
        } catch (\Exception $e) {
            return redirect()->route('admin.category.index')->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }
}
