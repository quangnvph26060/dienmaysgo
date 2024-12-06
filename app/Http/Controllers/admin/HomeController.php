<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\HomeRequest;
use App\Models\SgoHome;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $title = "Nội dung";

        if ($request->ajax()) {
            $data = SgoHome::select('id', 'name', 'slug',  'content');

            return DataTables::of($data)
                ->addColumn('image', function ($row) {
                    // Kiểm tra nếu có ảnh và hiển thị ảnh, nếu không thì hiển thị thông báo không có ảnh
                    return $row->image ? '<img src="' . asset('storage/' . $row->image) . '" alt="Image" style="width: 100px; height: auto;">' : '<p>No image</p>';
                })
                ->addColumn('content', function ($row) {
                    // Trả về nội dung HTML từ cột content
                    return $row->content;
                })
                ->addColumn('action', function ($row) {
                    return '<div style="display: flex;">
                            <a href="' . route('admin.home.edit', $row->id) . '" class="btn btn-primary btn-sm edit">
                                <i class="fas fa-edit btn-edit" title="Sửa"></i>
                            </a>
                            <a href="#" class="btn btn-danger btn-sm delete"
                                onclick="event.preventDefault(); document.getElementById(\'delete-form-' . $row->id . '\').submit();">
                                <i class="fas fa-trash btn-delete" title="Xóa"></i>
                            </a>
                            <form id="delete-form-' . $row->id . '" action="' . route('admin.home.delete', $row->id) . '" method="POST" style="display:none;">
                                ' . csrf_field() . '
                            </form>
                        </div>';
                })
                ->rawColumns(['image', 'content', 'action'])
                ->make(true);
        }

        $page = 'Nội dung';
        return view('backend.home.index', compact('title', 'page'));
    }


    public function create()
    {
        $page = 'Nội dung';
        $title = 'Thêm Nội dung';
        return view('backend.home.form', compact('title', 'page'));
    }

    public function edit($id)
    {
        $page = 'Nội dung';
        $title = 'Sửa Nội dung';
        $home = SgoHome::find($id);
        return view('backend.home.form', compact('home', 'title', 'page'));
    }

    public function store(HomeRequest $request)
    {
        try {
            // dd($request->all());
            // Tạo danh mục mới
            $home = SgoHome::create([
                'name' => $request->input('name'),
                'slug' => Str::slug($request->input('name')),  // Tạo slug từ title
                'content' => $request->input('content'),
                'is_published' => $request->input('is_published'),
                'title_seo' => $request->input('title_seo'),
                'description_seo' => $request->input('description_seo'),
                'keyword_seo' => $request->input('keyword_seo'),
            ]);

            // Trả về thông báo thành công
            return redirect()->route('admin.home.index')->with('success', 'Nội dung đã được thêm thành công');
        } catch (\Exception $e) {
            // Nếu có lỗi, bắt và hiển thị thông báo lỗi
            return redirect()->route('admin.home.index')->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    public function update(HomeRequest $request, $id)
    {

        try {
            $credentials = $request->validated();
            $home = SgoHome::find($id);
            $home->update($credentials);

            // Trả về thông báo thành công
            return redirect()->route('admin.home.index')->with('success', 'Nội dung đã được sửa thành công');
        } catch (\Exception $e) {
            // Nếu có lỗi, bắt và hiển thị thông báo lỗi
            return redirect()->back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            $home = SgoHome::findOrFail($id);
            $home->delete();
            return redirect()->route('admin.home.index')->with('success', 'Xóa Nội dung thành công!');
        } catch (\Exception $e) {
            return redirect()->route('admin.home.index')->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }
}
