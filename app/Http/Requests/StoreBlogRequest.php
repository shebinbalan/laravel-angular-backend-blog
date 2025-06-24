<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBlogRequest extends FormRequest
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
            'title' => 'required|string|unique:blogs,title|min:3',
            'slug' => 'nullable|string|unique:blogs,slug|regex:/^[a-z0-9-]+$/',
            'author_id' => 'nullable|exists:users,id',
            'category_id' => 'nullable|exists:categories,id',
            'published_at' => 'nullable|date',
            'status' => 'in:draft,published',
            'content' => 'nullable|string',
            'views' => 'nullable|integer|min:0',
            'is_featured' => 'required|boolean',
            'reading_time' => 'nullable|integer|min:1',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
        ];
    }
}
