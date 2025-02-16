<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Imports\ProductsImport;
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
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class ProductController extends Controller
{

    public function modifyProduct(Request $request)
    {
        // Loại bỏ dấu chấm trong giá trị price
        $request->merge([
            'price' => str_replace('.', '', $request->price),
            'discount_value' => str_replace('.', '', $request->discount_value)
        ]);

        $rule = $request->discount_type == 'amount' ? 'nullable|numeric|min:0' : 'nullable|numeric|max:100';

        $credentials = Validator::make(
            $request->all(),
            [
                'id' => 'required|exists:sgo_products,id',
                'name' => 'required|string|max:255',
                'price' => 'required|numeric',
                'quantity' => 'required|integer',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'discount_type' => 'nullable|in:percentage,amount',
                'discount_value' => $rule
            ],
            __('request.messages')
        );

        if ($credentials->fails()) {
            return response()->json([
                'success' => false,
                'message' => $credentials->errors()->first()
            ]);
        }
        $credentials =  $credentials->validated();

        try {

            if ($request->hasFile('image')) {
                $credentials['image'] = saveImages($request, 'image', 'products_main_images', 500, 500);
            }

            SgoProduct::find($credentials['id'])->update($credentials);
            return response()->json(['success' => true, 'message' => 'Cập nhật thành công.']);
        } catch (Exception $e) {
            Log::info($e->getMessage());
            return response()->json(['success' => false, 'message' => 'Có lỗi xảy ra. vui lòng thử lại sau!']);
        }
    }


    public function getCategories()
    {
        $categories = DB::table('sgo_category')->get();

        $sortedCategories = $this->sortCategories($categories);

        return response()->json($sortedCategories);
    }

    public function getAttributes()
    {
        $attributes = Attribute::query()->latest()->get();
        return response()->json($attributes);
    }

    public function getValues($id)
    {
        $values = AttributeValue::where('attribute_id', $id)->get();
        return response()->json($values);
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

    public function index(Request $request)
    {
        $page = 'Sản phẩm';
        $title = 'Danh sách sản phẩm';
        if ($request->ajax()) {
            return datatables()->of(SgoProduct::select(['id', 'name', 'price', 'quantity', 'import_price', 'category_id', 'view_count', 'discount_value', 'discount_type', 'image'])
                ->when($request->catalogue, function ($query) use ($request) {
                    // Kiểm tra xem có bộ lọc catalogue không và áp dụng điều kiện lọc
                    return $query->where('category_id', $request->catalogue);
                })
                ->when($request->attributeId, function ($query) use ($request) {
                    return $query->whereHas('attributes', function ($q) use ($request) {
                        $q->where('attribute_id', $request->attributeId);
                    });
                })
                ->when($request->attributeValueId, function ($query) use ($request) {
                    return $query->whereHas('attributeValues', function ($q) use ($request) {
                        $q->where('attribute_value_id', $request->attributeValueId);
                    });
                })
                ->with(['category', 'attributes', 'attributeValues'])
                ->latest()
                ->get())
                ->addColumn('price', function ($row) {
                    return number_format($row->price, 0, ',', '.');
                })
                ->addColumn('import_price', function ($row) {
                    return number_format($row->import_price, 0, ',', '.');
                })
                ->addColumn('checkbox', function ($row) {
                    return '<input type="checkbox" class="row-checkbox" value="' . $row->id . '" />';
                })
                ->addColumn('category_id', function ($row) {
                    return $row->category->name ?? '';
                })
                // ->addColumn('name', function ($row) {
                //     return "
                //     <strong class='text-primary'>$row->name</strong>";
                // })
                ->rawColumns(['checkbox', 'price'])
                ->addIndexColumn()
                ->make(true);
        }
        return view('backend.product.index', compact('page', 'title'));
    }

    public function add()
    {
        $page = 'Sản phẩm';
        $title = 'Thêm sản phẩm';
        $categories = SgoCategory::query()->whereNull('category_parent_id')->with('childrens')->get();
        $attributes = Attribute::query()->pluck('name', 'id');
        $brands = Brand::query()->pluck('name', 'id');
        $promotions = SgoPromotion::pluck('name', 'id');
        return view('backend.product.add', compact('categories', 'promotions', 'page', 'title', 'attributes', 'brands'));
    }

    public function edit($id)
    {
        $page = 'Sản phẩm';
        $title = 'Sửa sản phẩm';
        $categories = SgoCategory::query()->whereNull('category_parent_id')->with('childrens')->latest()->get();
        $promotions = SgoPromotion::pluck('name', 'id');
        $allAttributes = Attribute::pluck('name', 'id')->all();
        $brands = Brand::query()->pluck('name', 'id');


        $attributes = ProductAttributeValue::query()
            ->join('attributes', 'product_attribute_values.attribute_id', '=', 'attributes.id')
            ->where('sgo_product_id', $id)
            ->get([
                'product_attribute_values.attribute_id',
                'product_attribute_values.attribute_value_id',
                'attributes.name as attribute_name'
            ])
            ->keyBy('attribute_id') // <-- Chuyển về dạng key-value
            ->toArray();

        $allAttributeValues = AttributeValue::get()->groupBy('attribute_id')->map(function ($values) {
            return $values->pluck('value', 'id');
        })->toArray();

        $product = SgoProduct::query()->with(['attributeValues', 'brand'])->findOrFail($id);


        $images = $product->images;
        return view('backend.product.edit', compact('categories', 'promotions', 'product', 'page', 'title', 'images', 'attributes', 'allAttributeValues', 'allAttributes', 'brands'));
    }

    public function store(Request $request)
    {
        $rule = $request->discount_type == 'amount' ? 'nullable|numeric|min:0' : 'nullable|numeric|max:100';
        // lt:price
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
                'brand_id' => 'nullable|exists:brands,id',
                'tags' => 'nullable',
                'discount_type' => 'nullable|in:percentage,amount',
                'discount_value' => $rule,
                'discount_start_date' => 'nullable|date',
                'discount_end_date' => 'nullable|date|after_or_equal:discount_start_date',
                'module' => 'nullable'
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

            if ($validated['discount_end_date'] && is_null($validated['discount_start_date'])) {
                $validated['discount_start_date'] = now();
            }

            if ($request->hasFile('image')) {
                $validated['image'] = saveImages($request, 'image', 'products_main_images', 500, 500);
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
            } else {
                // Nếu không có thuộc tính nào được chọn, thêm các thuộc tính mặc định
                $defaultAttributes = [
                    ['attribute_id' => 26, 'attribute_value_id' => 44], // Nguồn điện 220V
                    ['attribute_id' => 23, 'attribute_value_id' => 45], // Bảo hành 6 tháng
                    ['attribute_id' => 21, 'attribute_value_id' => 28], // Xuất xứ Trung Quốc
                ];

                foreach ($defaultAttributes as $default) {
                    ProductAttributeValue::create([
                        'sgo_product_id' => $product->id,
                        'attribute_id' => $default['attribute_id'],
                        'attribute_value_id' => $default['attribute_value_id']
                    ]);
                }
            }

            toastr()->success('Thêm sản phẩm mới thành công');

            DB::commit();

            return redirect()->route('admin.product.index');
        } catch (Exception $e) {
            if (isset($validated['image']))  deleteImage($validated['image']);

            DB::rollBack();

            toastr()->error('Đã có lỗi xảy ra. Vui lòng thử lại sau!');

            Log::error('Failed to create new product: ' . $e->getMessage());

            return back()->withInput();
        }
    }
    public function update(Request $request, $id)
    {
        // dd($request->attribute_id);

        $product = SgoProduct::findOrFail($id);
        // lt:price
        $rule = $request->discount_type == 'amount' ? 'nullable|numeric|min:0' : 'nullable|numeric|max:100';

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
                'brand_id' => 'nullable|exists:brands,id',
                'tags' => 'nullable',
                'discount_type' => 'nullable|in:percentage,amount',
                'discount_value' => $rule,
                'discount_start_date' => 'nullable|date',
                'discount_end_date' => 'nullable|date|after_or_equal:discount_start_date',
                'module' => 'nullable'
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
                'discount_value' => 'Giá trị giảm'
            ]
        );

        DB::beginTransaction();
        try {

            // Xử lý ngày tháng đúng định dạng
            if ($validated['discount_start_date']) {
                $validated['discount_start_date'] = Carbon::parse($validated['discount_start_date'])->format('Y-m-d H:i:s');
            }

            if ($validated['discount_end_date']) {
                $validated['discount_end_date'] = Carbon::parse($validated['discount_end_date'])->format('Y-m-d H:i:s');
            }

            if ($validated['discount_end_date'] && is_null($validated['discount_start_date'])) {
                $validated['discount_start_date'] = now()->format('Y-m-d H:i:s');
            }

            // dd($validated);

            if ($request->hasFile('image')) {
                deleteImage($product->image);

                $validated['image'] = saveImages($request, 'image', 'products_main_images', 500, 500);
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

            // if ($request->has('brand_id')) {
            //     $product->brands()->sync($request->brand_id);
            // }

            if ($request->attribute_id) {

                ProductAttributeValue::where('sgo_product_id', $product->id)->delete();

                $data = [];
                foreach ($request->attribute_value_id as $key => $attributeValueId) {
                    if (isset($request->attribute_value_id[$key])) {
                        $data[] = [
                            'sgo_product_id' => $product->id,
                            'attribute_id' => $key,
                            'attribute_value_id' => $attributeValueId,
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

    public function importData(Request $request)
    {
        Excel::import(new ProductsImport, $request->file('file'));
    }
}
