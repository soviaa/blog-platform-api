<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Blog;

class Image extends Model
{
    protected $fillable =[
        'image',
        'blog_id'
    ];

    public function blog(){
        return $this->belongsTo(Blog::class);
    }
}
