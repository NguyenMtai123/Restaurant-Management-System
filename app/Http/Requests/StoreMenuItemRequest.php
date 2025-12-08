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
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:100',
            'slug' => 'nullable|string|max:100|unique:menu_items,slug',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|max:2048', // jpg, png...
        ];
    }
}
