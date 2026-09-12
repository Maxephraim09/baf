<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GalleryItem extends Model
{
    protected $fillable = ['title', 'caption', 'image', 'category', 'is_active', 'sort_order'];
    protected $casts = ['is_active' => 'boolean'];
}