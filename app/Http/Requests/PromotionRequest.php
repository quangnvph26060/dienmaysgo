<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PromotionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $promotionId = $this->route('id'); // Lấy id từ route nếu có

        return [
            'name' => 'required|string|max:255|unique:sgo_promotions,name,' . $promotionId,
            'description' => 'nullable|string',
            'discount' => 'required|numeric|min:0|max:100',
            'start_date' => 'required|date|before_or_equal:end_date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'status' => 'required',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return __('request.messages');
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'name' => 'tên chương trình khuyến mãi',
            'description' => 'mô tả',
            'discount' => 'phần trăm giảm giá',
            'start_date' => 'ngày bắt đầu',
            'end_date' => 'ngày kết thúc',
            'status' => 'trạng thái',
        ];
    }
}
