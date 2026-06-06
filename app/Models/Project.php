<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'description', 'image', 'goal_amount', 
        'raised_amount', 'location', 'status'
    ];

    protected $casts = [
        'goal_amount' => 'decimal:2',
        'raised_amount' => 'decimal:2',
    ];

    public function getProgressAttribute()
    {
        if ($this->goal_amount > 0) {
            return ($this->raised_amount / $this->goal_amount) * 100;
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