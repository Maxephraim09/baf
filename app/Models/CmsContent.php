<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CmsContent extends Model
{
    protected $fillable = ['section_id', 'title', 'subtitle', 'description', 'image', 'button_text', 'button_link', 'metadata', 'is_active', 'sort_order'];

    protected $casts = ['metadata' => 'array', 'is_active' => 'boolean'];

    public function section(): BelongsTo
    {
        return $this->belongsTo(CmsSection::class, 'section_id');
    }
}