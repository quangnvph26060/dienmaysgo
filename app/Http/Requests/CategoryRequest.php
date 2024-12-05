<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
{
    /**
     * Xác định người dùng có quyền thực hiện yêu cầu này hay không.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // Hoặc kiểm tra quyền người dùng nếu cần
    }

    /**
     * Lấy các quy tắc xác thực cho yêu cầu.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|max:255', // Tên danh mục là bắt buộc và có độ dài tối đa 255 ký tự
            'description' => 'required',
            'title_seo' => 'required|string|max:255', // Tiêu đề SEO là tùy chọn, nếu có thì phải là chuỗi và tối đa 255 ký tự
            'description_seo' => 'required|string|max:1000', // Mô tả SEO là tùy chọn, nếu có thì phải là chuỗi và tối đa 1000 ký tự
            'keyword_seo' => 'required|string|max:255', // Từ khóa SEO là tùy chọn, nếu có thì phải là chuỗi và tối đa 255 ký tự
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
            'name' => 'Tên danh mục',
            'description' => 'Mô tả',
            'title_seo' => 'Tiêu đề SEO',
            'description_seo' => 'Mô tả SEO',
            'keyword_seo' => 'Từ khóa SEO',
        ];
    }
}