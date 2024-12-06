<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\SgoCategory;
use App\Models\SgoFuel;
use App\Models\SgoOrigin;
use App\Models\SgoProduct;
use App\Models\SgoPromotion;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return datatables()->of(SgoProduct::select(['id', 'name', 'price', 'quantity'])->get())
                ->addColumn('price', function ($row) {
                    return number_format($row->price, 0, ',', '.') . ' VND';
                })
                ->addColumn('quantity', function ($row) {
                    return number_format($row->quantity, 0, ',', '.');
                })
                ->addColumn('action', function ($row) {
                    return '
                    <div class="btn-group">
                        <button class="btn btn-danger btn-sm delete-btn" data-url="' . route('admin.product.delete', $row->id) . '">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </div>
                ';
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }
        return view('backend.product.index');
    }

    public function add()
    {
        $categories = SgoCategory::pluck('name', 'id');
        $origins = SgoOrigin::pluck('name', 'id');
        $fuels = SgoFuel::pluck('name', 'id');
        $promotions = SgoPromotion::pluck('name', 'id');
        return view('backend.product.add', compact('categories', 'origins', 'fuels', 'promotions'));
    }

    public function store(Request $request)
    {
        $validated  = $request->validate(
            [
                'name' => 'required|unique:sgo_products',
                'price' => 'nullable|numeric',
                'quantity' => 'nullable|numeric',
                'category_id' => 'required',
                'origin_id' => 'required',
                'fuel_id' => 'required',
                'promotions_id' => 'nullable',
                'description_short' => 'required',
                'description' => 'required',
                'title_seo' => 'nullable',
                'description_seo' => 'nullable',
                'keyword_seo' => 'nullable',
                'image' => 'required|mimes:jpeg,png,gif,svg,webp,jfif|max:2048',
            ],
            __('request.messages'),
            [
                'name' => 'Tên sản phẩm',
                'price' => 'Giá sản phẩm',
                'quantity' => 'Số lượng sản phẩm',
                'category_id' => 'Danh mục sản phẩm',
                'origin_id' => 'Xuất xứ sản phẩm',
                'fuel_id' => 'Nhiên liệu sản phẩm',
                'promtions_id' => 'Chương trình khuyến mãi',
                'description_short' => 'Mô tả ngắn của sản phẩm',
                'description' => 'Mô tả sản phẩm',
                'title_seo' => 'Tiêu đề SEO sản phẩm',
                'description_seo' => 'Mô tả SEO sản phẩm',
                'keyword_seo' => 'Từ khóa SEO sản phẩm',
                'image' => 'Ảnh sản phẩm',
            ]
        );
        
        try {

            if ($request->hasFile('image')) {
                $validated['image'] = saveImage($request, 'image', 'products_main_images');
            }

            SgoProduct::create($validated);
            toastr()->success('Thêm sản phẩm mới thành công');

            return redirect()->route('admin.product.index');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Failed to create new product: ' . $e->getMessage());
            return back();
        }
    }
}
