<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ConfigRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        return [
            'company_name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'warehouse' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'email' => 'required|email|max:255',
            'tax_code' => 'required|string|max:50',
            'link_fb' => 'required|url',
            'link_ig' => 'required|url',
            'zalo_number' => 'required|string|max:15',
            'path' => 'required|string',
            'title_seo' => 'required|string|max:255',
            'description_seo' => 'required|string',
            'keywords_seo' => 'required|string',
            'url' => 'required|url',
        ];
    }
    public function messages()
    {
        return __('request.messages');
    }

    /**
     * Tùy chỉnh tên các trường trong form.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'company_name' => 'Tên công ty',
            'address' => 'Địa chỉ',
            'warehouse' => 'Kho hàng',
            'phone' => 'Số điện thoại',
            'email' => 'Email',
            'tax_code' => 'Mã số thuế',
            'link_fb' => 'Link Facebook',
            'link_ig' => 'Link Instagram',
            'zalo_number' => 'Số Zalo',
            'path' => 'Đường dẫn',
            'title_seo' => 'Tiêu đề SEO',
            'description_seo' => 'Mô tả SEO',
            'keywords_seo' => 'Từ khóa SEO',
            'url' => 'Đường dẫn URL',
        ];
    }
}
