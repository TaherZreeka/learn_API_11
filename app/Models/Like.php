<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
     protected $fillable =[
        'post_id',
        'user_id',
    ];
     function user() {
    return $this->belongsTo(User::class, 'user_id');
}
 function post() {
    return $this->belongsTo(Post::class, 'post');
}
}