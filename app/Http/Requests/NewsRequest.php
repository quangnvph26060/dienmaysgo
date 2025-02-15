<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NewsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;  // Đảm bảo rằng yêu cầu này được phép
    }

    /**
     * Các quy tắc xác thực cho form request.
     */
    public function rules()
    {
        $newsId = $this->route('id');  // Lấy id từ URL route, nếu bạn đang cập nhật

        return [
            'title' => 'required|string|max:255|unique:sgo_news,title,' . $newsId,
            'content' => 'required|string',
            'image' => isset($newsId) ? 'nullable' : 'required',
            'is_published' => 'required|boolean',
            'title_seo' => 'nullable|string|max:255',
            'description_seo' => 'nullable|string',
            'keyword_seo' => 'nullable|string',
        ];
    }

    /**
     * Tùy chỉnh thông báo lỗi khi xác thực không thành công.
     *
     * @return array
     */
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
            'title' => 'Tiêu đề',
            'slug' => 'Slug',
            'content' => 'Nội dung',
            'image' => 'Ảnh',
            'is_published' => 'Đã xuất bản',
            'title_seo' => 'Tiêu đề SEO',
            'description_seo' => 'Mô tả SEO',
            'keyword_seo' => 'Từ khóa SEO',
        ];
    }
}
