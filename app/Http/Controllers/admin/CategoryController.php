<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\SgoCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class CategoryController extends Controller
{
    //
    public function index(Request $request)
    {
        $title = "Danh mục";
        if ($request->ajax()) {

            $data = collect($this->getCategories());

            return DataTables::of($data)
                ->addColumn('name', function ($row) {
                    return str_repeat('- ', $row->level) . '<a href="' . route('admin.category.update', $row->id) . '"><strong>' . $row->name . '</strong></a>';
                })
                ->addColumn('parent_name', function ($row) {
                    return $row->parent_name ? $row->parent_name : '--------';
                })
                ->addColumn('product_count', function ($row) { // Thêm số lượng sản phẩm
                    return "<a onclick=\"localStorage.setItem('params', '" . $row->id . "')\" href='" . route('admin.product.index') . "'>$row->product_count</a>";
                })
                ->addColumn('checkbox', function ($row) {
                    return '<input type="checkbox" class="row-checkbox" value="' . $row->id . '" />';
                })
                ->rawColumns(['checkbox', 'name', 'product_count'])
                ->make(true);
        }
        $page = 'Danh mục';

        $parents = SgoCategory::query()->select('name', 'location', 'id')->whereNull('category_parent_id')->orderBy('location', 'asc')->get()->toArray();

        return view('backend.category.index', compact('title', 'page', 'parents'));
    }

    public function getCategories()
    {
        $categories = DB::table('sgo_category as c')
            ->leftJoin('sgo_category as p', 'c.category_parent_id', '=', 'p.id')
            ->leftJoin('sgo_products', 'c.id', '=', 'sgo_products.category_id')
            ->select(
                'c.id',
                'c.name',
                'c.category_parent_id',  // Thêm trường category_parent_id vào SELECT
                'p.name as parent_name',
                DB::raw('COUNT(sgo_products.id) as product_count')
            )
            ->groupBy('c.id', 'c.name', 'c.category_parent_id', 'p.name')  // Thêm vào GROUP BY
            ->get();

        return $this->sortCategories($categories);
    }




    private function sortCategories($categories, $parentId = null, $level = 0)
    {
        $result = [];

        foreach ($categories as $category) {
            if ($category->category_parent_id == $parentId) {
                $category->level = $level;
                $result[] = $category;

                // Gọi đệ quy để lấy danh mục con
                $children = $this->sortCategories($categories, $category->id, $level + 1);
                $result = array_merge($result, $children);
            }
        }

        return $result;
    }


    public function create()
    {
        $page = 'Danh mục';
        $title = 'Thêm danh mục';
        $parentCategories = collect($this->getCategories());

        return view('backend.category.create', compact('parentCategories', 'title', 'page'));
    }

    public function edit($id)
    {
        $page = 'Danh mục';
        $title = 'Sửa danh mục';
        $category = SgoCategory::find($id);
        $parentCategories = collect($this->getCategories());
        return view('backend.category.create', compact('category', 'parentCategories', 'title', 'page'));
    }

    public function store(CategoryRequest $request)
    {
        try {
            $credentials = $request->validated();

            $credentials['name'] = capitalizeWords($credentials['name']);

            if (!isset($credentials['slug'])) {
                $credentials['slug'] = Str::slug($credentials['name']);
            }

            if ($request->hasFile('logo')) $credentials['logo'] =  saveImage($request, 'logo', 'category_images');
            // Tạo danh mục mới
            SgoCategory::create($credentials);

            Cache::forget('sorted_categories');

            // Trả về thông báo thành công
            return redirect()->route('admin.category.index')->with('success', 'Danh mục đã được thêm thành công');
        } catch (\Exception $e) {
            logInfo($e->getMessage());
            // Nếu có lỗi, bắt và hiển thị thông báo lỗi
            return redirect()->back()->withInput();
        }
    }

    public function update(CategoryRequest $request, $id)
    {
        try {

            $category = SgoCategory::find($id);

            $credentials = $request->validated();

            $credentials['name'] = capitalizeWords($credentials['name']);

            if (!isset($credentials['slug'])) {
                $credentials['slug'] = Str::slug($credentials['name']);
            }

            if ($request->hasFile('logo')) $credentials['logo'] = saveImage($request, 'logo', 'category_images');

            $category->update($credentials);

            Cache::forget('sorted_categories');

            // Trả về thông báo thành công
            return redirect()->route('admin.category.index')->with('success', 'Danh mục đã được sửa thành công');
        } catch (\Exception $e) {
            // Nếu có lỗi, bắt và hiển thị thông báo lỗi
            return redirect()->back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            $category = SgoCategory::findOrFail($id);  // Tìm danh mục hoặc báo lỗi nếu không tìm thấy
            $category->delete();
            return redirect()->route('admin.category.index')->with('success', 'Xóa danh mục thành công!');
        } catch (\Exception $e) {
            return redirect()->route('admin.category.index')->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }
}
