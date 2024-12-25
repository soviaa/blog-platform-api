<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Blog;

class Comment extends Model
{
    protected $fillable = [
        'content',
        'user_id',
        'blog_id'
    ];
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function blog(){
        return $this->belongsTo(Blog::class);
    }
}
