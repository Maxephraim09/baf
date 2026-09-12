<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'slug', 'tag', 'description', 'image', 'goal_amount',
        'raised_amount', 'location', 'status', 'start_date', 'end_date',
        'sort_order', 'is_active'
    ];

    protected $casts = [
        'goal_amount' => 'decimal:2',
        'raised_amount' => 'decimal:2',
        'start_date' => 'date',
        'end_date' => 'date',
        'is_active' => 'boolean',
    ];

    public function donations(): HasMany
    {
        return $this->hasMany(Donation::class);
    }

    public function successfulDonations(): HasMany
    {
        return $this->donations()->whereIn('status', ['successful', 'completed', 'paid', 'confirmed']);
    }

    public function getProgressAttribute()
    {
        $raised = (float) ($this->raised_amount ?? 0);
        if ($this->goal_amount > 0) {
            return min(($raised / (float) $this->goal_amount) * 100, 100);
        }
        return 0;
    }

    public function getDaysRemainingAttribute()
    {
        if ($this->created_at && $this->status === 'active') {
            return now()->diffInDays($this->created_at->addMonths(6));
        }
        return null;
    }
}