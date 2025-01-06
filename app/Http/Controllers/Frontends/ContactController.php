<?php

namespace App\Http\Controllers\Frontends;

use App\Http\Controllers\Controller;
use App\Models\ContactRequest;
use App\Models\SgoProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    public function contact()
    {

        $product = SgoProduct::query()->where('slug', request('product'))->first();

        return view('frontends.pages.contact', compact('product'));
    }

    public function postContact(Request $request)
    {
        $data = Validator::make(
            $request->all(),
            [
                'name' => 'required',
                'email' => 'required|email',
                'subject' => 'required',
                'message' => 'nullable'
            ],
            [
                [
                    'name' => 'Vui lòng nhập dữ liệu cho trường này.',
                    'email' => 'Vui lòng nhập dữ liệu cho trường này.',
                    'subject' => 'Vui lòng nhập dữ liệu cho trường này.',
                ]
            ]
        );

        if ($data->fails()) {
            return response()->json([
                'status' => 'validation_failed',
                'message' => 'Có một hoặc nhiều mục nhập có lỗi. Vui lòng kiểm tra và thử lại.',
                'invalid_fields' => $data->errors()
            ], 422);
        }

        $credentials = $data->validated();

        $recentContact = ContactRequest::where('email', $credentials['email'])
            ->where('created_at', '>=', Carbon::now()->subMinutes(5))
            ->first();

        if ($recentContact) {
            return response()->json([
                'message' => 'Bạn đã gửi liên hệ trong vòng 5 phút trước. Vui lòng chờ thêm.',
            ], 401);
        }

        ContactRequest::updateOrCreate(
            ['email' => $credentials['email']],
            $credentials
        );

        return response()->json([
            'message' => 'Gửi yêu cầu thành công. Vui lòng theo dõi email trong thời gian sớm tới.',
        ], 200);
    }
}
