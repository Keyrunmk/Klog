<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostReport extends Model
{
    use HasFactory;

    protected $fillable = ["case","post_id", "user_id"];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
