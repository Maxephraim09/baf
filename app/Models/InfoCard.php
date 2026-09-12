<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InfoCard extends Model
{
    protected $fillable = ['badge', 'title', 'description', 'image', 'link_text', 'link_url', 'is_active', 'sort_order'];
    protected $casts = ['is_active' => 'boolean'];
}