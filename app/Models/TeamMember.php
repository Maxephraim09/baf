<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeamMember extends Model
{
    protected $fillable = ['name', 'role', 'bio', 'image', 'social_links', 'is_founder', 'is_active', 'sort_order'];
    protected $casts = ['social_links' => 'array', 'is_founder' => 'boolean', 'is_active' => 'boolean'];
}