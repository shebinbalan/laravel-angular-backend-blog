<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CommentController extends Controller
{
   public function index($blogId)
{
    return Comment::where('blog_id', $blogId)->latest()->get();
}

public function store(Request $request)
{
    $validated = $request->validate([
        'blog_id' => 'required|exists:blogs,id',
        'author_name' => 'required|string|max:255',
        'content' => 'required|string',
    ]);

    return Comment::create($validated);
}
}
