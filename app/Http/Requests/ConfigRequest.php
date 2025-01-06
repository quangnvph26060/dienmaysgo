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
            'company_name' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'warehouse' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:15',
            'email' => 'nullable|email|max:255',
            'tax_code' => 'nullable|string|max:50',
            'link_fb' => 'nullable|url',
            'link_ig' => 'nullable|url',
            'zalo_number' => 'nullable|string|max:15',
            'path' => 'nullable|image|mimes:png,jpg,jpeg,gif,webp',
            'icon' => 'nullable|image|mimes:png,jpg,jpeg,gif,webp',
            'title_seo' => 'nullable|string|max:255',
            'description_seo' => 'nullable|string',
            'keywords_seo' => 'nullable|string',
            'url' => 'nullable|url',
            'content' => 'nullable',
            'introduct_title' => 'nullable',
            'introduction' => 'nullable',
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
            'content' => 'Giới thiệu',
        ];
    }
}
