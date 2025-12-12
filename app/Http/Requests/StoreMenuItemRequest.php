<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMenuItemRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // kiểm tra quyền admin nếu cần
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:100',
            'category_id' => 'required|exists:menu_categories,id',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'slug' => 'nullable|string|unique:menu_items,slug',
        ];
    }

}
