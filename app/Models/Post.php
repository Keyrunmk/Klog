<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ["slug", "title", "body", "user_id", "category_id", "location_id"];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function author()
    {
        return $this->belongsToMany(User::class, "user_id");
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function image()
    {
        return $this->morphOne(Image::class, "imageable");
    }

    public function tags()
    {
        return $this->morphToMany(Tag::class, "taggable");
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }
}