<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BoardMember extends Model
{
    protected $fillable = ['name', 'role', 'bio', 'image', 'sort_order', 'is_active'];

    protected $casts = ['is_active' => 'boolean'];
}
