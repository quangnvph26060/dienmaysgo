<?php

namespace App\Http\Requests\Brand;

use Illuminate\Foundation\Http\FormRequest;

class StoreBrandRequest extends FormRequest
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
            'name' => 'required|unique:brands,name',
            'slug' => 'nullable|unique:brands,slug',
            'description' => 'nullable|min:5|max:28'
        ];
    }

    public function messages(): array
    {
        return __('request.messages');
    }

    public function attributes(): array
    {
        return [
            'name' => 'Tên',
            'description' => 'Mô tả'
        ];
    }
}
