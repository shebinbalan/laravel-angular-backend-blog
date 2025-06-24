<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Tag;

class TagController extends Controller
{
   public function index()
    {
        return Tag::all();
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $slug = Str::slug($request->name);

        // Ensure unique slug
        $originalSlug = $slug;
        $i = 1;
        while (Tag::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $i++;
        }

        $tag = Tag::create([
            'name' => $request->name,
            'slug' => $slug,
        ]);

        return response()->json($tag, 201);
    }

    public function update(Request $request, Tag $tag)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $slug = Str::slug($request->name);
        $originalSlug = $slug;
        $i = 1;
        while (Tag::where('slug', $slug)->where('id', '!=', $tag->id)->exists()) {
            $slug = $originalSlug . '-' . $i++;
        }

        $tag->update([
            'name' => $request->name,
            'slug' => $slug,
        ]);

        return response()->json($tag);
    }

    public function destroy(Tag $tag)
    {
        $tag->delete();
        return response()->json(null, 204);
    }
}
