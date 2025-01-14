<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Brand;
use App\Models\ProductAttributeValue;
use App\Models\SgoCategory;
use App\Models\SgoFuel;
use App\Models\SgoOrigin;
use App\Models\SgoProduct;
use App\Models\SgoProductImages;
use App\Models\SgoPromotion;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $page = 'Sản phẩm';
        $title = 'Danh sách sản phẩm';
        if ($request->ajax()) {
            return datatables()->of(SgoProduct::select(['id', 'name', 'price', 'quantity', 'import_price', 'category_id'])->with('category')->latest()->get())
                ->addColumn('price', function ($row) {
                    return number_format($row->price, 0, ',', '.') . ' VND' . '<i class="fas fa-pen-alt ms-2 pointer" data-id=' . $row->id . '></i>';
                })
                ->addColumn('import_price', function ($row) {
                    return number_format($row->import_price, 0, ',', '.') . ' VND';
                })
                ->addColumn('quantity', function ($row) {
                    return number_format($row->quantity, 0, ',', '.');
                })
                ->addColumn('checkbox', function ($row) {
                    return '<input type="checkbox" class="row-checkbox" value="' . $row->id . '" />';
                })
                ->addColumn('category_id', function ($row) {
                    return $row->category->name;
                })
                ->addColumn('name', function ($row) {
                    $urlEdit =  route('admin.product.detail', $row->id);
                    $urlDestroy = route('admin.product.delete', $row->id);
                    return "
                    <strong class='text-primary'>$row->name</strong>
                    " . view('components.action', compact('row', 'urlEdit', 'urlDestroy')) . "
                    ";
                })
                ->editColumn('created_at', function ($row) {
                    return date('d/m/Y', $row->created_at);
                })
                ->rawColumns(['checkbox', 'name', 'price'])
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
        $attributes = Attribute::query()->pluck('name', 'id');
        $brands = Brand::query()->pluck('name', 'id');
        $promotions = SgoPromotion::pluck('name', 'id');
        return view('backend.product.add', compact('categories', 'promotions', 'page', 'title', 'attributes', 'brands'));
    }

    public function edit($id)
    {
        $page = 'Sản phẩm';
        $title = 'Sửa sản phẩm';
        $categories = SgoCategory::pluck('name', 'id');
        $promotions = SgoPromotion::pluck('name', 'id');
        $allAttributes = Attribute::pluck('name', 'id')->all();
        $brands = Brand::query()->pluck('name', 'id');


        $attributes = ProductAttributeValue::query()
            ->where('sgo_product_id', $id)
            ->get(['attribute_id', 'attribute_value_id'])
            ->toArray();

        $allAttributeValues = AttributeValue::get()->groupBy('attribute_id')->map(function ($values) {
            return $values->pluck('value', 'id');
        })->toArray();

        $product = SgoProduct::query()->with(['attributeValues', 'brands'])->findOrFail($id);


        $images = $product->images;
        return view('backend.product.edit', compact('categories', 'promotions', 'product', 'page', 'title', 'images', 'attributes', 'allAttributeValues', 'allAttributes', 'brands'));
    }

    public function store(Request $request)
    {
        $validated  = $request->validate(
            [
                'name' => 'required|unique:sgo_products',
                'price' => 'nullable|numeric',
                'import_price' => 'nullable|numeric',
                'quantity' => 'nullable|numeric',
                'category_id' => 'required',
                'promotions_id' => 'nullable',
                'description_short' => 'nullable',
                'description' => 'nullable',
                'title_seo' => 'nullable',
                'description_seo' => 'nullable',
                'keyword_seo' => 'nullable',
                'image' => 'required|mimes:jpeg,png,gif,svg,webp,jfif|max:2048',
                'attribute_id' => 'nullable|array',
                'attribute_id.*' => 'exists:attributes,id',
                'attribute_value_id' => 'nullable|array',
                'attribute_value_id.*' => 'exists:attribute_values,id',
                'brand_id' => 'nullable|array',
                'brand_id.*' => 'exists:brands,id',
                'tags' => 'nullable'
            ],
            __('request.messages'),
            [
                'name' => 'Tên sản phẩm',
                'price' => 'Giá sản phẩm',
                'import_price' => 'Giá nhập sản phẩm',
                'quantity' => 'Số lượng sản phẩm',
                'category_id' => 'Danh mục sản phẩm',
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
            DB::beginTransaction();

            if ($request->hasFile('image')) {
                $validated['image'] = saveImage($request, 'image', 'products_main_images');
            }


            $product = SgoProduct::create($validated);

            if ($request->hasFile('images')) {
                $images = $request->file('images');
                foreach ($images as $image) {
                    $imagePath = saveImageNew($image, 'image', 'products_images');

                    if ($imagePath) {
                        SgoProductImages::create([
                            'product_id' => $product->id,
                            'image' => $imagePath,
                        ]);
                    }
                }
            }

            if ($request->has('brand_id')) {
                $product->brands()->sync($request->brand_id);
            }

            if ($request->attribute_id) {
                $data = [];
                foreach ($request->attribute_id as $key => $attributeId) {
                    $data[] = [
                        'sgo_product_id' => $product->id,
                        'attribute_id' => $attributeId,
                        'attribute_value_id' => $request->attribute_value_id[$key]
                    ];
                }

                ProductAttributeValue::insert($data);
            }

            toastr()->success('Thêm sản phẩm mới thành công');

            DB::commit();

            return redirect()->route('admin.product.index');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Failed to create new product: ' . $e->getMessage());
            return back();
        }
    }
    public function update(Request $request, $id)
    {

        $product = SgoProduct::findOrFail($id);

        $validated  = $request->validate(
            [
                'name' => 'required|unique:sgo_products,name,' . $id,
                'price' => 'nullable|numeric',
                'import_price' => 'nullable|numeric',
                'quantity' => 'nullable|numeric',
                'category_id' => 'required',
                'promotions_id' => 'nullable',
                'description_short' => 'nullable',
                'description' => 'nullable',
                'title_seo' => 'nullable',
                'description_seo' => 'nullable',
                'keyword_seo' => 'nullable',
                'image' => 'nullable|mimes:jpeg,png,gif,svg,webp,jfif|max:2048',
                'attribute_id' => 'nullable|array',
                'attribute_id.*' => 'exists:attributes,id',
                'attribute_value_id' => 'nullable|array',
                'attribute_value_id.*' => 'exists:attribute_values,id',
                'brand_id' => 'nullable|array',
                'brand_id.*' => 'exists:brands,id',
                'tags' => 'nullable'
            ],
            __('request.messages'),
            [
                'name' => 'Tên sản phẩm',
                'import_price' => 'Giá nhập sản phẩm',
                'quantity' => 'Số lượng sản phẩm',
                'category_id' => 'Danh mục sản phẩm',
                'promtions_id' => 'Chương trình khuyến mãi',
                'description_short' => 'Mô tả ngắn của sản phẩm',
                'description' => 'Mô tả sản phẩm',
                'title_seo' => 'Tiêu đề SEO sản phẩm',
                'description_seo' => 'Mô tả SEO sản phẩm',
                'keyword_seo' => 'Từ khóa SEO sản phẩm',
                'image' => 'Ảnh sản phẩm',
            ]
        );

        DB::beginTransaction();
        try {

            if ($request->hasFile('image')) {
                deleteImage($product->image);

                $validated['image'] = saveImage($request, 'image', 'products_main_images');
            }

            $oldImages = $request->input('old', []);

            SgoProductImages::where('product_id', $id)
                ->whereNotIn('id', $oldImages)
                ->get()
                ->each(function ($image) {
                    deleteImage($image->image);
                    $image->delete();
                });

            if ($request->hasFile('images')) {
                $images = $request->file('images');
                foreach ($images as $image) {
                    $imagePath = saveImageNew($image, 'image', 'products_images');

                    if ($imagePath) {
                        SgoProductImages::create([
                            'product_id' => $id,
                            'image' => $imagePath,
                        ]);
                    }
                }
            }

            $product->update($validated);

            if ($request->has('brand_id')) {
                $product->brands()->sync($request->brand_id);
            }

            if ($request->attribute_id) {
                ProductAttributeValue::where('sgo_product_id', $product->id)->delete();

                $data = [];
                foreach ($request->attribute_id as $key => $attributeId) {
                    if (isset($request->attribute_value_id[$key])) {
                        $data[] = [
                            'sgo_product_id' => $product->id,
                            'attribute_id' => $attributeId,
                            'attribute_value_id' => $request->attribute_value_id[$key],
                        ];
                    }
                }

                ProductAttributeValue::insert($data);
            }

            toastr()->success('Cập nhập phẩm mới thành công');

            DB::commit();

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


    public function changeSelect(Request $request)
    {
        if ($request->selectedId) {
            $attrbuteValues = AttributeValue::query()->where('attribute_id', $request->selectedId)->pluck('value', 'id')->all();

            return response()->json($attrbuteValues);
        }
    }

    public function handleChangePrice(Request $request, string $id)
    {
        $price = str_replace('.', '', $request->input('price'));

        $request->validate([
            'price' => ['required', 'numeric', 'min:0']
        ]);

        $product = SgoProduct::findOrFail($id);

        if ($price < $product->import_price) {
            return response()->json([
                'status' => false,
                'message' => 'Giá bán phải lớn hơn giá nhập!',
                'price' => formatAmount($product->price) . ' VND'
            ]);
        }

        $product->price = $price;
        $product->save();

        return response()->json(['status' => true, 'message' => 'Giá đã được cập nhật', 'price' => formatAmount($product->price) . ' VND']);
    }
}
