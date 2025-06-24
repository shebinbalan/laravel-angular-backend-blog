<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $fillable = [
            'title',
            'slug',
            'author_id',
            'category_id',
            'image',
            'content',
            'published_at',
            'status',
            'views',
            'is_featured',
            'reading_time',
        ];


     public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

  

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'blog_tag');
    }

    public function comments()
{
    return $this->hasMany(Comment::class);
}

    
}
