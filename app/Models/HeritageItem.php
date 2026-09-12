<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class HeritageItem extends Model
{
    protected $fillable = ['type', 'title', 'slug', 'description', 'source', 'media_path', 'thumbnail', 'metadata', 'is_active', 'download_count'];

    protected $casts = ['metadata' => 'array', 'is_active' => 'boolean'];

    protected static function booted(): void
    {
        static::creating(function (self $item): void {
            $item->slug ??= Str::slug($item->title);
        });
    }
}
