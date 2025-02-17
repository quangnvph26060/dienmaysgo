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

        if ($request->ajax()) {
            $data = SgoNews::select(
                'id',
                'title',
                'slug',
                'is_published',
                'published_at',
            );

            return DataTables::of($data)
                ->addColumn('title', function ($row) {
                    return "<a href=" . route('admin.news.update', $row->id) . "><strong class='text-primary'>$row->title</strong></a>";
                })
                ->addColumn('slug', function ($row) {
                    return "<a target='_blank' href=" . route('news.list', $row->slug) . ">" . route('news.list', $row->slug) . "</a>";
                })
                ->addColumn('checkbox', function ($row) {
                    return '<input type="checkbox" class="row-checkbox" value="' . $row->id . '" />';
                })
                ->rawColumns(['title', 'checkbox', 'slug'])
                ->make(true);
        }

        return view('backend.news.index');
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
        $credentials = $request->validated();

        try {
            // dd($request->all());
            // Tạo danh mục mới
            // $new = SgoNews::create([
            //     'title' => $request->input('title'),
            //     'slug' => Str::slug($request->input('title')),  // Tạo slug từ title
            //     'content' => $request->input('content'),
            //     'image' => saveImage($request, 'image', 'new_images'),
            //     'is_published' => $request->input('is_published'),
            //     'title_seo' => $request->input('title_seo'),
            //     'description_seo' => $request->input('description_seo'),
            //     'keyword_seo' => $request->input('keyword_seo'),
            // ]);

            if ($request->hasFile('image')) {
                $credentials['image'] = saveImage($request, 'image', 'new_images');
            }

            if (empty($credentials['slug'])) {
                $credentials['slug'] = Str::slug($credentials['title']);
            }

            SgoNews::create($credentials);
            // Trả về thông báo thành công
            return redirect()->route('admin.news.index')->with('success', 'Bài viết đã được thêm thành công');
        } catch (\Exception $e) {
            // Nếu có lỗi, bắt và hiển thị thông báo lỗi
            return back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
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
