<?php

namespace App\Http\Requests\AttributeValue;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAttributeValue extends FormRequest
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
    public function rules(): array
    {

        return [
            'value' => 'required|unique:attribute_values,value, ' . $this->attribute_value->id,
            'slug' => 'nullable|unique:attribute_values,slug, ' . $this->attribute_value->id,
            'description' => 'nullable|max:28|min:5',
            'attribute_id' => 'required|exists:attributes,id'
        ];
    }

    public function messages(): array
    {
        return __('request.messages');
    }

    public function attributes(): array
    {
        return [
            'value' => 'Giá trị',
            'slug' => 'Đường dẫn',
            'description' => 'Mô tả'
        ];
    }
}
