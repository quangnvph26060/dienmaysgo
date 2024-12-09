<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\SgoCategory;
use App\Models\SgoFuel;
use App\Models\SgoOrigin;
use App\Models\SgoProduct;
use App\Models\SgoProductImages;
use App\Models\SgoPromotion;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $page = 'Sản phẩm';
        $title = 'Danh sách sản phẩm';
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
                        <button class="btn btn-danger btn-sm delete-product-btn" data-url="' . route('admin.product.delete', $row->id) . '">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </div>
                ';
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }
        return view('backend.product.index', compact('page', 'title'));
    }

    public function add()
    {
        $page = 'Sản phẩm';
        $title = 'Thêm sản phẩm';
        $categories = SgoCategory::pluck('name', 'id');
        $origins = SgoOrigin::pluck('name', 'id');
        $fuels = SgoFuel::pluck('name', 'id');
        $promotions = SgoPromotion::pluck('name', 'id');
        return view('backend.product.add', compact('categories', 'origins', 'fuels', 'promotions' ,'page', 'title'));
    }

    public function edit($id)
    {
        $page = 'Sản phẩm';
        $title = 'Sửa sản phẩm';
        $categories = SgoCategory::pluck('name', 'id');
        $origins = SgoOrigin::pluck('name', 'id');
        $fuels = SgoFuel::pluck('name', 'id');
        $promotions = SgoPromotion::pluck('name', 'id');
        $product = SgoProduct::findOrFail($id);
        $images = $product->images;
        return view('backend.product.edit', compact('categories', 'origins', 'fuels', 'promotions', 'product','page', 'title', 'images'));
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


            $product = SgoProduct::create($validated);
            if ($request->hasFile('images')) {
                $images = $request->file('images');
                Log::info($images);
                foreach ($images as $image) {
                    $imagePath = saveImageNew($image, 'image', 'products_images');

                    if ($imagePath) {
                        Log::info($imagePath);
                        SgoProductImages::create([
                            'product_id' => $product->id,
                            'image' => $imagePath,
                        ]);
                    }
                }
            }
            toastr()->success('Thêm sản phẩm mới thành công');

            return redirect()->route('admin.product.index');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Failed to create new product: ' . $e->getMessage());
            return back();
        }
    }
    public function update(Request $request, $id)
    {
        dd($request->all());

        $product = SgoProduct::findOrFail($id);
        $validated  = $request->validate(
            [
                'name' => 'required|unique:sgo_products,name,' . $id,
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
                'image' => 'nullable|mimes:jpeg,png,gif,svg,webp,jfif|max:2048',
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
                deleteImage($product->image);

                $validated['image'] = saveImage($request, 'image', 'products_main_images');
            }

            if ($request->hasFile('images')) {
                $images = $request->file('images');
                Log::info($images);
                foreach ($images as $image) {
                    $imagePath = saveImageNew($image, 'image', 'products_images');

                    if ($imagePath) {
                        Log::info($imagePath);
                        SgoProductImages::create([
                            'product_id' => $id, // Liên kết với sản phẩm
                            'image' => $imagePath, // Đường dẫn file ảnh đã lưu
                        ]);
                    }
                }
            }


            $product->update($validated);
            toastr()->success('Cập nhập phẩm mới thành công');

            return redirect()->route('admin.product.index');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Failed to update product: ' . $e->getMessage());
            return back();
        }
    }

    public function delete($id)
    {
        $product = SgoProduct::findOrFail($id);
        DB::beginTransaction();

        try {
            if ($product->image) {
                deleteImage($product->image);
            }

            $product->delete();
            DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'Xóa sản phẩm thành công'
            ]);
        } catch (Exception $e) {
            Log::error('Failed to delete this Product: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Xóa sản phẩm thất bại',
            ]);
        }
    }
}
