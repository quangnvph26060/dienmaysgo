<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OriginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }


    public function rules()
    {
        $origin = $this->route('id'); // Lấy id từ URL route (giả sử route có tên 'admin.category.update')

        return [
            'name' => 'required|unique:sgo_origin,name,' . $origin . '|max:255', // Tên danh mục là bắt buộc và có độ dài tối đa 255 ký tự
            'description' => 'required',

        ];
    }

    /**
     * Tùy chỉnh thông báo lỗi xác thực.
     *
     * @return array
     */
    public function messages()
    {
        return __('request.messages');
    }

    /**
     * Tùy chỉnh tên trường dữ liệu (thuộc tính).
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'name' => 'Xuất xứ',
            'description' => 'Mô tả',
        ];
    }
}
