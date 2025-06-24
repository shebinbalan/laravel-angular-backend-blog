<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBlogRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules()
{
    $blogId = $this->route('id');

    return [
        'title' => 'required|min:3|unique:blogs,title,' . $this->route('blog'),
        'slug' => 'nullable|string|unique:blogs,slug,' . $this->route('blog'),
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
