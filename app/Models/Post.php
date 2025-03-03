<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\DocBlock\Tags\Uses;

class Post extends Model
{

    protected $fillable =[
        'title',
        'content',
        'user_id',
    ];
    function user() {
    return $this->belongsTo(Uses::class, 'user_id');
}

public function comments() { // Renamed from `comment` to `comments` for clarity
        return $this->hasMany(Comment::class); // Assuming a post has many comments
    }
}
