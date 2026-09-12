<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    protected $fillable = ['author_name', 'role', 'testimonial', 'image', 'rating', 'is_active', 'sort_order'];
    protected $casts = ['is_active' => 'boolean'];
}