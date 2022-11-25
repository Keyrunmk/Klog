<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    protected $fillable = ["country_name"];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function locationable()
    {
        return $this->morphTo();
    }
}
