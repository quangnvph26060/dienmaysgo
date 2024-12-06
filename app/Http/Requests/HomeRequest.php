<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HomeRequest extends FormRequest
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
            'name' => 'required|string|max:255|unique:sgo_home,name,' . $newsId,
            'content' => 'required|string',
            'title_seo' => 'required|string|max:255',
            'description_seo' => 'required|string',
            'keyword_seo' => 'required|string',
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
            'name' => 'Tiêu đề',
            'content' => 'Nội dung',
            'title_seo' => 'Tiêu đề SEO',
            'description_seo' => 'Mô tả SEO',
            'keyword_seo' => 'Từ khóa SEO',
        ];
    }
}
