<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\NewsRequest;
use App\Models\SgoNews;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class NewsController extends Controller
{
    //
    public function index(Request $request)
    {
        $title = "Bài viết";

        if ($request->ajax()) {
            $data = SgoNews::select('id', 'title', 'slug', 'image', 'content');

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
                            <a href="' . route('admin.news.edit', $row->id) . '" class="btn btn-primary btn-sm edit">
                                <i class="fas fa-edit btn-edit" title="Sửa"></i>
                            </a>
                            <a href="#" class="btn btn-danger btn-sm delete"
                                onclick="event.preventDefault(); document.getElementById(\'delete-form-' . $row->id . '\').submit();">
                                <i class="fas fa-trash btn-delete" title="Xóa"></i>
                            </a>
                            <form id="delete-form-' . $row->id . '" action="' . route('admin.news.delete', $row->id) . '" method="POST" style="display:none;">
                                ' . csrf_field() . '
                            </form>
                        </div>';
                })
                ->rawColumns(['image', 'content', 'action'])
                ->make(true);
        }

        $page = 'Bài viết';
        return view('backend.news.index', compact('title', 'page'));
    }


    public function create()
    {
        $page = 'Bài viết';
        $title = 'Thêm Bài viết';
        return view('backend.news.form', compact('title', 'page'));
    }

    public function edit($id)
    {
        $page = 'Bài viết';
        $title = 'Sửa Bài viết';
        $new = SgoNews::find($id);
        return view('backend.news.form', compact('new', 'title', 'page'));
    }

    public function store(NewsRequest $request)
    {
        try {
            // dd($request->all());
            // Tạo danh mục mới
            $new = SgoNews::create([
                'title' => $request->input('title'),
                'slug' => Str::slug($request->input('title')),  // Tạo slug từ title
                'content' => $request->input('content'),
                'image' => saveImage($request, 'image', 'new_images'),
                'is_published' => $request->input('is_published'),
                'title_seo' => $request->input('title_seo'),
                'description_seo' => $request->input('description_seo'),
                'keyword_seo' => $request->input('keyword_seo'),
            ]);

            // Trả về thông báo thành công
            return redirect()->route('admin.news.index')->with('success', 'Bài viết đã được thêm thành công');
        } catch (\Exception $e) {
            // Nếu có lỗi, bắt và hiển thị thông báo lỗi
            return redirect()->route('admin.news.index')->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    public function update(NewsRequest $request, $id)
    {

        try {
            $credentials = $request->validated();
            $new = SgoNews::find($id);
            if ($request->hasFile('image')) $credentials['image'] =  saveImage($request, 'image', 'new_images');
            $new->update($credentials);

            // Trả về thông báo thành công
            return redirect()->route('admin.news.index')->with('success', 'Bài viết đã được sửa thành công');
        } catch (\Exception $e) {
            // Nếu có lỗi, bắt và hiển thị thông báo lỗi
            return redirect()->back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            $new = SgoNews::findOrFail($id);
            $new->delete();
            return redirect()->route('admin.news.index')->with('success', 'Xóa Bài viết thành công!');
        } catch (\Exception $e) {
            return redirect()->route('admin.news.index')->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }
}
