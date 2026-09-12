<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LandingEvent extends Model
{
    protected $table = 'landing_events';
    protected $fillable = ['title', 'description', 'event_date', 'location', 'image', 'status', 'is_active', 'sort_order'];
    protected $casts = ['event_date' => 'datetime', 'is_active' => 'boolean'];
}