<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        "slug",
        "title",
        "body",
        "user_id",
        "category_id",
        "location_id",
    ];

    public function scopeFilter($query, array $filters)
    {
        $query->when(
            $filters["search"] ?? false,
            fn ($query, $search) =>
            $query->where(
                fn ($query) =>
                $query->where("title", "like", "%" . $search . "%")
                    ->orWhere("body", "like", "%" . $search . "%")
            )
        );
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class, "user_id");
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

    public function postLocation()
    {
        return $this->belongsTo(Location::class);
    }

    public function location()
    {
        return $this->morphMany(Location::class, "locationable");
    }

    public function postReports()
    {
        return $this->hasMany(PostReport::class);
    }
}
