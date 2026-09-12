<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CmsSection extends Model
{
    protected $fillable = ['key', 'name', 'description', 'is_enabled', 'sort_order'];

    protected $casts = ['is_enabled' => 'boolean'];

    public function contents(): HasMany
    {
        return $this->hasMany(CmsContent::class, 'section_id');
    }
}