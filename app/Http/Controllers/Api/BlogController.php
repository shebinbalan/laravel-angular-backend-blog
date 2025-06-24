<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\Category;
use App\Models\Tag;
use App\Http\Requests\StoreBlogRequest;
use App\Http\Requests\UpdateBlogRequest;


class BlogController extends Controller
{
public function index(Request $request)
{
    $query = Blog::query()->with(['category', 'tags']);

    if ($search = $request->search) {
        $query->where(function ($q) use ($search) {
            $q->where('title', 'like', "%$search%")
              ->orWhere('content', 'like', "%$search%")
              ->orWhereHas('tags', fn($q2) => $q2->where('name', 'like', "%$search%"));
        });
    }

    if ($categoryId = $request->category_id) {
        $query->where('category_id', $categoryId);
    }

    if ($status = $request->status) {
        $query->where('status', $status);
    }

    return response()->json($query->paginate(10));
}

   
   public function store(StoreBlogRequest $request)
{
    $validated = $request->validated();

    if ($request->hasFile('image')) {
        $validated['image'] = $request->file('image')->store('blogs', 'public');
    }

    $blog = Blog::create($validated);
    $blog->tags()->sync($request->tags ?? []);

    return response()->json($blog->load(['category', 'tags', 'author']));
}

  
    public function show($id)
    {
        $blog = Blog::with(['category', 'tags', 'author'])->findOrFail($id);
        return response()->json($blog);
    }

   
    public function update(UpdateBlogRequest $request, $id)
{
    $blog = Blog::findOrFail($id);
    $validated = $request->validated();

    if ($request->hasFile('image')) {
        $validated['image'] = $request->file('image')->store('blogs', 'public');
    }

    $blog->update($validated);
    $blog->tags()->sync($request->tags ?? []);

    return response()->json($blog->load(['category', 'tags', 'author']));
}

  
    public function destroy($id)
    {
        $blog = Blog::findOrFail($id);
        $blog->tags()->detach();
        $blog->delete();

        return response()->json(['message' => 'Blog deleted']);
    }
}
