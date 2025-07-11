<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ConfigRequest;
use App\Models\Attribute;
use App\Models\configFilter;
use App\Models\ConfigPayment;
use App\Models\SgoConfig;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ConfigController extends Controller
{
    public function configSupport()
    {
        $config = SgoConfig::first();
        return view('backend.config.support', compact('config'));
    }

    public function index()
    {
        $page = 'Cấu hình';
        $title = "Cấu hình";
        $config = SgoConfig::first();
        return view('backend.config.index', compact('config', 'page', 'title'));
    }

    public function update(ConfigRequest $request)
    {
        try {
            $credentials = $request->validated();

            // Lấy bản ghi đầu tiên, nếu không có thì tạo mới
            $config = SgoConfig::firstOrCreate([], $credentials);

            // Cập nhật nếu bản ghi đã tồn tại
            if (!$config->wasRecentlyCreated) {
                if ($request->hasFile('path')) {
                    $credentials['path'] = saveImage($request, 'path', 'logo');
                }

                if ($request->hasFile('icon')) {
                    $credentials['icon'] = saveImage($request, 'icon', 'icon');
                }

                $credentials['maintenance_mode'] = !empty($credentials['maintenance_mode']) && $credentials['maintenance_mode'] == 1 ? true : false;

                $config->update($credentials);
            }

            return redirect()->back()->with('success', 'Cấu hình đã được xử lý thành công');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    public function updateSupport(Request $request)
    {
        $credentials = $request->validate(
            [
                'introduct_title' => 'nullable',
                'introduction' => 'nullable',
                'support' => 'nullable|array',
            ],
            __('request.messages')
        );

        $config = SgoConfig::first();

        $config->update($credentials);

        toastr()->success('Thay đổi thành công.');

        return redirect()->back();
    }

    public function configPayment($id = null)
    {
        if ($id) {
            $config = ConfigPayment::query()->where('id', 2)->first();
            $banks = DB::table('banks')->pluck('name', 'bin')->toArray();

            return view('backend.config.transfer_payment', compact('banks', 'config'));
        }
        $configPayments = ConfigPayment::query()->get();
        return view('backend.config.payment', compact('configPayments'));
    }

    public function configPaymentPost(Request $request, string $id = null)
    {
        $credentials = $request->validate(
            [
                'name' => 'required|unique:config_payments,name,' . $request->id,
                'description' => 'nullable',
                'id' => 'required|exists:config_payments,id',
                'payment_percentage' => 'nullable|numeric',
                'bank_code' => 'nullable|numeric',
                'account_number' => 'nullable|numeric',
            ],
            __('request.messages')
        );
        try {
            $configPayment = ConfigPayment::query()->findOrFail($request->id);

            $credentials['published'] = $request->published ?  true : false;

            $configPayment->update($credentials);

            return true;
        } catch (\Exception $e) {
            Log::info($e->getMessage());
            return response()->json([
                'status' => false,
            ], 500);
        }
    }

    public function configTransferPayment(Request $request)
    {
        $credentials = $request->validate([
            'name' => 'required|max:100',
            'description' => 'nullable',
            'account_details.account_name' => 'required|array',
            'account_details.account_name.*' => 'required|string|max:255',
            'account_details.account_number' => 'required|array',
            'account_details.account_number.*' => 'required|numeric|digits_between:6,20',
            'account_details.bank_code' => 'required|array',
            'account_details.bank_code.*' => 'required|string|distinct',
        ], __('request.messages'));

        $config = ConfigPayment::query()->where('id', 2)->first();

        $config->update($credentials);

        toastr()->success('Lưu thay đổi thành công.');

        return redirect()->route('admin.config.config-payment');
    }

    public function handleChangePublishPayment(Request $request)
    {

        try {
            $configPayment = ConfigPayment::find($request->id);

            $configPayment->published = !$configPayment->published;

            $configPayment->save();

            return response()->json(['status' => true, 'published' => $configPayment->published]);
        } catch (\Exception $e) {
            Log::error('Đã có lỗi xảy ra', ['message' => $e->getMessage()]);
            return response()->json(['status' => false, 'message' => 'Đã có lỗi xảy ra. Vui lòng thử lại sau!'], 500);
        }
    }

    public function configSlider()
    {
        $images = Slider::query()->latest()->get()->map(function ($item) {
            return [
                'id' => $item->id,
                'src' => showImage($item->url)
            ];
        });

        return view('backend.config.slider', compact('images'));
    }

    public function handleSubmitSlider(Request $request)
    {
        // Validate request
        $validatedData = $request->validate([
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:png,jpg,webp,jpeg|max:2048',
        ]);

        // Xóa các slider không nằm trong danh sách `old`
        if ($request->has('old')) {
            Slider::whereNotIn('id', (array)$request->old)->each(function ($slider) {
                deleteImage($slider->url); // Xóa file hình ảnh
                $slider->delete(); // Xóa bản ghi trong DB
            });
        } else {
            Slider::truncate();
        }

        // Xử lý lưu các hình ảnh mới
        if ($request->hasFile('images')) {
            $uploadedUrls = saveImages($request, 'images', 'sliders', 990, 280, true);
            $slidersData = collect($uploadedUrls)->map(fn($url) => ['url' => $url])->toArray();

            Slider::insert($slidersData); // Thêm tất cả các slider mới vào DB trong một truy vấn
        }

        // Gửi thông báo thành công
        toastr()->success('Lưu thay đổi thành công.');

        return back();
    }

    public function configFilter()
    {
        if (request()->ajax()) {
            DB::reconnect();
            return datatables()->of(configFilter::query()->select(['id', 'filter_type', 'title', 'attribute_id', 'option_price'])->orderBy('location', 'ASC')
                ->get())
                ->addColumn('title', function ($row) {
                    // $urlDestroy = route('admin.brands.destroy', $row);
                    return "
                    <strong class='text-primary'>$row->title</strong>
                    " . view('components.action', compact('row')) . "
                    ";
                })
                ->addColumn('attribute_id', function ($row) {
                    if (!empty($row->attribute->name)) {
                        return $row->attribute->name;
                    } elseif (!empty($row->option_price)) {
                        return $row->option_price;
                    } else {
                        return '---';
                    }
                })
                ->addColumn('checkbox', function ($row) {
                    return '<input type="checkbox" class="row-checkbox" value="' . $row->id . '" />';
                })
                ->addIndexColumn()
                ->rawColumns(['title', 'checkbox'])
                ->make(true);
        }
        $attributes = Attribute::query()->pluck('name', 'id')->toArray();
        return view('backend.config.filter', compact('attributes'));
    }

    public function handleSubmitFilter(Request $request)
    {
        $credentials = $request->validate([
            'filter_type' => 'required|in:attribute,brand,price',
            'title' => 'required|unique:config_filters',
            'attribute_id' => 'nullable|exists:attributes,id',
            'option_price' => 'nullable|string'
        ]);

        configFilter::create($credentials);

        return response()->json([
            'success' => true,
            'message' => 'Thêm bộ lọc thành công'
        ]);
    }

    public function handleSubmitChangeFilter(Request $request, string $id)
    {
        $credentials = $request->validate([
            'filter_type' => 'required|in:attribute,brand,price',
            'title' => 'required|unique:config_filters,title,' . $id,
            'attribute_id' => 'nullable|exists:attributes,id',
            'option_price' => 'nullable|string'
        ]);

        if (!$data  = configFilter::query()->find($id)) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy bản ghi trên hệ thống!'
            ], 401);
        }

        $data->update($credentials);

        return response()->json([
            'success' => true,
            'message' => 'Cập nhật bộ lọc thành công!'
        ]);
    }
}
